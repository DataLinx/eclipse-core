<?php

namespace Eclipse\Core\View\Grids;

use Eclipse\Core\Foundation\Grid\AbstractDataGrid;
use Eclipse\Core\Framework\Grid\Action;
use Eclipse\Core\Framework\Grid\Columns\ActionColumn;
use Eclipse\Core\Framework\Grid\Columns\Column;
use Eclipse\Core\Framework\Grid\Columns\ImageColumn;
use Eclipse\Core\Framework\Grid\Filters\BooleanFilter;
use Eclipse\Core\Framework\Grid\Filters\SearchFilter;
use Eclipse\Core\Models\User;

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
            new Action('edit', url('/users/{id}/edit')),
            //new Action('delete'),
        ]))->setWidth(125);

        // Filters
        $this->filters[] = (new SearchFilter(self::$model))->addPartialCondition(['name', 'surname', 'email', 'full_name']);
        $this->filters[] = new BooleanFilter('email_verified_at', _('Email verified'));
    }
}
