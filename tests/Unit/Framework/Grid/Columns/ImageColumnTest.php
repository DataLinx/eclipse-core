<?php declare(strict_types=1);

namespace SDLX\Core\Tests\Unit\Framework\Grid\Columns;

use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Framework\Grid\Columns\ImageColumn;
use SDLX\Core\Models\User;

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
