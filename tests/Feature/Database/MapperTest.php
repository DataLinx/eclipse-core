<?php

namespace SDLX\Core\Tests\Feature\Database;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Framework\Database\Mapper;
use SDLX\Core\Tests\TestObjects\Configs\InvalidConfigColumnType;
use SDLX\Core\Tests\TestObjects\Configs\InvalidConfigDefinition;
use SDLX\Core\Tests\TestObjects\Configs\UpdatedValidConfig;
use SDLX\Core\Tests\TestObjects\Configs\ValidConfig;

class MapperTest extends PackageTestCase
{
    private $mapper;

    /**
     * @var Builder
     */
    private $schema;

    public function setUp(): void
    {
        parent::setUp();

        $this->mapper = new Mapper();
        $this->schema = DB::connection()->getSchemaBuilder();
    }

    public function test_config_can_be_mapped()
    {
        $this->mapper->map(ValidConfig::class);

        $this->assertTrue($this->schema->hasTable('core_test_config'));
    }

    public function test_config_can_be_updated()
    {
        $this->mapper->map(ValidConfig::class);

        // Add column
        $this->mapper->map(UpdatedValidConfig::class);
        $this->assertTrue($this->schema->hasColumn('core_test_config', 'another_bool'));

        if (env('DB_CONNECTION') !== 'sqlite')
        {
            // Remove column - this does not work with sqlite databases
            $this->mapper->removeDeprecatedColumns(UpdatedValidConfig::class);
            $this->assertFalse($this->schema->hasColumn('core_test_config', 'test_object'));
        }

        // Invalid config
        $this->expectExceptionMessage('Column definition property not set');
        $this->mapper->removeDeprecatedColumns(InvalidConfigDefinition::class);
    }

    public function test_non_existing_class_can_be_detected()
    {
        $non_existent_class = '\Some\Class';

        $this->expectExceptionMessage("Class $non_existent_class does not exist");
        $this->mapper->map($non_existent_class);
    }

    public function test_empty_definition_can_be_detected()
    {
        $this->expectExceptionMessage("Column definition property not set");
        $this->mapper->map(InvalidConfigDefinition::class);
    }

    public function test_invalid_column_type_can_be_detected()
    {
        $this->expectExceptionMessage(sprintf('Could not create column %s: %s', 'col', 'Unknown column type'));
        $this->mapper->map(InvalidConfigColumnType::class);
    }
}
