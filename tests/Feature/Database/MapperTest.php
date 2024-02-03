<?php

use Eclipse\Core\Framework\Database\Mapper;
use Illuminate\Support\Facades\DB;
use Tests\TestObjects\Configs\InvalidConfigColumnType;
use Tests\TestObjects\Configs\InvalidConfigDefinition;
use Tests\TestObjects\Configs\UpdatedValidConfig;
use Tests\TestObjects\Configs\ValidConfig;

beforeEach(function () {
    $this->mapper = new Mapper();
    $this->schema = DB::connection()->getSchemaBuilder();
});

test('config can be mapped', function () {
    $this->mapper->map(ValidConfig::class);

    expect($this->schema->hasTable('core_test_config'))->toBeTrue();
});

test('config can be updated', function () {
    $this->mapper->map(ValidConfig::class);

    // Add column
    $this->mapper->map(UpdatedValidConfig::class);
    expect($this->schema->hasColumn('core_test_config', 'another_bool'))->toBeTrue();

    if (env('DB_CONNECTION') !== 'sqlite') {
        // Remove column - this does not work with sqlite databases
        $this->mapper->removeDeprecatedColumns(UpdatedValidConfig::class);
        expect($this->schema->hasColumn('core_test_config', 'test_object'))->toBeFalse();
    }

    // Invalid config
    $this->expectExceptionMessage('Column definition property not set');
    $this->mapper->removeDeprecatedColumns(InvalidConfigDefinition::class);
});

test('non existing class can be detected', function () {
    $non_existent_class = '\Some\Class';

    $this->expectExceptionMessage("Class $non_existent_class does not exist");
    $this->mapper->map($non_existent_class);
});

test('empty definition can be detected', function () {
    $this->expectExceptionMessage('Column definition property not set');
    $this->mapper->map(InvalidConfigDefinition::class);
});

test('invalid column type can be detected', function () {
    $this->expectExceptionMessage(sprintf('Could not create column %s: %s', 'col', 'Unknown column type'));
    $this->mapper->map(InvalidConfigColumnType::class);
});
