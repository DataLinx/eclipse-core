<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Columns\ImageColumn;
use Eclipse\Core\Models\User;

uses(PackageTestCase::class);

test('can be created', function () {
    $column = new ImageColumn('image', 'Image', 100, 50);

    expect($column->getAccessor())->toEqual('image')
        ->and($column->getLabel())->toEqual('Image');

    $user = User::factory()->make();

    // No image by default
    expect($column->render($user))->toEqual('');

    // Set image
    $user->image = 'user_image.jpg';

    $query_params = [
        'w' => 100,
        'h' => 50,
    ];

    expect($column->render($user))->toEqual('<img src="img/'.$user->image.'?'.http_build_query($query_params).'"/>');
});
