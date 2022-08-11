<?php

namespace Ocelot\Core\Database;

use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\DB;
use Ocelot\Core\Foundation\Mappable;

class Mapper
{
    const TYPE_BOOL = 'boolean';
    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';

    const TYPE_ARRAY = 'array';
    const TYPE_MSTRING = 'mstring'; // Multi-language string
    const TYPE_MTEXT = 'mtext'; // Multi-language text (longer than string)
    const TYPE_OBJECT = 'object';

    /**
     * @var Builder
     */
    private $schema;

    public function __construct()
    {
        $this->schema = DB::connection()->getSchemaBuilder();
    }

    /**
     * Map class to database table
     *
     * @param string $class Class FQN
     * @throws Exception
     */
    public function map(string $class)
    {
        if (! class_exists($class)) {
            throw new Exception("Class $class does not exist");
        }

        $blank_object = new $class;
        $table = $blank_object->getTable();
        $definition = $class::getDefinition();

        if (empty($definition)) {
            throw new Exception("Column definition property not set");
        }

        if ( ! $this->schema->hasTable($table)) {

            $this->create($table, $definition);

        } else {

            $this->update($table, $definition);
        }
    }

    /**
     * Create new table
     *
     * @param string $table_name Table name
     * @param array $definition Columns definition
     */
    private function create(string $table_name, array $definition)
    {
        $this->schema->create($table_name, function (Blueprint $table) use ($definition) {

            $table->id();

            foreach ($definition as $key => $value) {

                list($column, $attr) = $this->processColumnDefinition($key, $value);

                switch ($column) {
                    // Preset columns
                    case 'site_id':
                        $table->foreignId('site_id')
                            ->constrained('core_site')
                            ->onDelete($attr['on_delete'] ?? 'cascade')
                            ->onUpdate($attr['on_update'] ?? 'cascade');
                        break;

                    default:
                        try {
                            $this->createColumn($table, $column, $attr);
                        } catch (Exception $exception) {
                            throw new Exception("Could not create column $column: ". $exception->getMessage(), null, $exception);
                        }
                }
            }
        });
    }

    /**
     * Update existing table
     *
     * @param string $table_name Table name
     * @param array $definition Columns definition
     */
    private function update(string $table_name, array $definition)
    {
        $after = null;

        foreach ($definition as $key => $value) {

            list($column, $attr) = $this->processColumnDefinition($key, $value);

            if ( ! $this->schema->hasColumn($table_name, $column)) {
                $this->schema->table($table_name, function (Blueprint $table) use ($column, $attr, $after) {

                    try {
                        $this->createColumn($table, $column, $attr, $after);
                    } catch (Exception $exception) {
                        throw new Exception("Could not create column $column: ". $exception->getMessage(), null, $exception);
                    }

                });
            }

            $after = $column;
        }
    }

    /**
     * Process column definition - auto-set presets, add defaults...
     *
     * @param mixed $key Definition key
     * @param mixed $value Definition value
     * @return array
     */
    private function processColumnDefinition($key, $value)
    {
        if (is_int($key) and is_string($value)) {
            // Transform short definition to defaults
            switch ($value) {
                case 'site_id':
                    $column = 'site_id';
                    $attr = [];
                    break;

                // Standard string
                default:
                    $column = $value;
                    $attr = [
                        'type' => self::TYPE_STRING,
                    ];
            }

            return [$column, $attr];
        }

        return [$key, $value];
    }

    /**
     * Create column for table
     *
     * @param Blueprint $table Table blueprint instance
     * @param string $column_name Column name
     * @param array $attributes Column attributes
     * @param string|null $after After column
     * @return ColumnDefinition
     * @throws Exception
     */
    private function createColumn(Blueprint $table, string $column_name, array $attributes, string $after = null)
    {
        switch ($attributes['type'] ?? null) {

            case self::TYPE_BOOL:
                $cd = $table->boolean($column_name);
                break;

            case self::TYPE_DATE:
                $cd = $table->date($column_name);
                break;

            case self::TYPE_DATETIME:
                $cd = $table->dateTime($column_name);
                break;

            case self::TYPE_FLOAT:
                $cd = $table->float($column_name, $attributes['length'] ?? 8, $attributes['decimals'] ?? 2);
                break;

            case self::TYPE_INTEGER:
                $cd = $table->bigInteger($column_name);
                break;

            case self::TYPE_STRING:
                $cd = $table->string($column_name);
                break;

            case self::TYPE_TEXT:
                $cd = $table->text($column_name);
                break;

            case self::TYPE_ARRAY:
            case self::TYPE_MSTRING:
            case self::TYPE_MTEXT:
            case self::TYPE_OBJECT:
                $cd = $table->binary($column_name);
                break;

            default:
                throw new Exception('Unknown column type');
        }

        if (isset($attributes['default'])) {
            $cd->default($attributes['default']);
        }

        if ($attributes['unsigned'] ?? false) {
            $cd->unsigned();
        }

        $cd->nullable( ! isset($attributes['required']) OR ! $attributes['required']);

        if ($after) {
            $cd->after($after);
        }

        return $cd;
    }

    /**
     * Remove deprecated columns
     *
     * @todo Needs to be fixed for SQLite databases, so that MapperTest::testUpdateMap() can run
     * @param string $class Object class
     * @throws Exception
     */
    public function removeDeprecatedColumns(string $class)
    {
        /* @var $class Mappable */
        $blank_instance = new $class;
        $table_name = $blank_instance->getTable();
        $definition = $class::getDefinition();

        if (empty($definition)) {
            throw new Exception("Column definition property not set");
        }

        foreach ($this->schema->getColumnListing($table_name) as $table_col) {
            if ($table_col === 'id') {
                continue;
            }

            foreach ($definition as $key => $value) {
                list($column,) = $this->processColumnDefinition($key, $value);

                if ($column === $table_col) {
                    // Still in definition, go to next table column
                    continue 2;
                }
            }

            // Not found, drop column
            try {
                $this->schema->table($table_name, function (Blueprint $table) use ($table_col) {
                    $table->dropColumn($table_col);
                });
            } catch (Exception $exception) {
                throw new Exception("Could not drop column $table_col: ". $exception->getMessage(), null, $exception);
            }
        }
    }
}
