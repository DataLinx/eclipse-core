<?php

namespace SDLX\Core\View\Grids;

use SDLX\Core\Foundation\Grid\AbstractDataGrid;
use SDLX\Core\Framework\Grid\Action;
use SDLX\Core\Framework\Grid\Columns\ActionColumn;
use SDLX\Core\Framework\Grid\Columns\Column;
use SDLX\Core\Framework\Grid\Columns\ImageColumn;
use SDLX\Core\Framework\Grid\Filters\BooleanFilter;
use SDLX\Core\Framework\Grid\Filters\SearchFilter;
use SDLX\Core\Models\User;

class Users extends AbstractDataGrid
{
    protected static string $model = User::class;

    public function boot(): void
    {
        $this->columns[] = (new Column('id', _('ID')))
            ->setWidth(50);

        $this->columns[] = (new ImageColumn('image', _('Image'), 50, 50))
            ->setWidth(75)
            ->setSortable(false);

        $this->columns[] = (new Column('name', _('Name')))
            ->setWidth(100);

        $this->columns[] = (new Column('surname', _('Surname')))
            ->setWidth(100);

        $this->columns[] = (new Column('full_name', _('Full name')))
            ->setWidth(200);

        $this->columns[] = new Column('email', _('Email address'));

        $this->columns[] = new Column('email_verified_at', _('Email verified'));

        $this->columns[] = (new ActionColumn([
            new Action('edit', url("/users/{id}/edit")),
            //new Action('delete'),
        ])) ->setWidth(125);

        // Filters
        $this->filters[] = (new SearchFilter(self::$model))->addPartialCondition(['name', 'surname', 'email', 'full_name']);
        $this->filters[] = new BooleanFilter('email_verified_at', _('Email verified'));
    }
}
