<?php declare(strict_types=1);

namespace Tests\Unit\Framework\Grid\Columns;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Columns\ImageColumn;
use Eclipse\Core\Models\User;

class ImageColumnTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $column = new ImageColumn('image', 'Image', 100, 50);

        $this->assertEquals('image', $column->getAccessor());
        $this->assertEquals('Image', $column->getLabel());

        $user = User::factory()->make();

        // No image by default
        $this->assertEquals('', $column->render($user));

        // Set image
        $user->image = 'user_image.jpg';

        $query_params = [
            'w' => 100,
            'h' => 50,
        ];

        $this->assertEquals('<img src="img/'. $user->image .'?'. http_build_query($query_params) .'"/>', $column->render($user));
    }
}
