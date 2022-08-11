<?php

namespace Ocelot\Core\Tests\Feature\Database;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Ocelot\Core\Database\Mapper;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\Tests\TestObjects\Configs\InvalidConfigColumnType;
use Ocelot\Core\Tests\TestObjects\Configs\InvalidConfigDefinition;
use Ocelot\Core\Tests\TestObjects\Configs\UpdatedValidConfig;
use Ocelot\Core\Tests\TestObjects\Configs\ValidConfig;

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

    public function testNonExistingClass()
    {
        $non_existent_class = '\Some\Class';

        $this->expectExceptionMessage("Class $non_existent_class does not exist");
        $this->mapper->map($non_existent_class);
    }

    public function testEmptyDefinition()
    {
        $this->expectExceptionMessage("Column definition property not set");
        $this->mapper->map(InvalidConfigDefinition::class);
    }

    public function testCreateMap()
    {
        $this->mapper->map(ValidConfig::class);

        $this->assertTrue($this->schema->hasTable('core_test_config'));
    }

    public function testInvalidColumnType()
    {
        $this->expectExceptionMessage(sprintf('Could not create column %s: %s', 'col', 'Unknown column type'));
        $this->mapper->map(InvalidConfigColumnType::class);
    }

    public function testUpdateMap()
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
}
