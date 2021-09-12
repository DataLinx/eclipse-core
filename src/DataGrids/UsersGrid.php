<?php

namespace Ocelot\Core\DataGrids;

use Ocelot\Core\Foundation\AbstractGridDefinition;
use Ocelot\Core\Framework\Grid\Action;
use Ocelot\Core\Framework\Grid\Columns\ActionColumn;
use Ocelot\Core\Framework\Grid\Columns\Column;
use Ocelot\Core\Framework\Grid\Columns\ImageColumn;
use Ocelot\Core\Models\User;

class UsersGrid extends AbstractGridDefinition
{
    public function __construct()
    {
        $this->columns[] = new Column('id', _('ID'));
        $this->columns[] = new ImageColumn('image', _('Image'), 50, 50);
        $this->columns[] = new Column('name', _('Name'));
        $this->columns[] = new Column('surname', _('Surname'));
        $this->columns[] = new Column('full_name', _('Full name'));
        $this->columns[] = new Column('email', _('Email address'));
        $this->columns[] = new ActionColumn([
            new Action('edit', url("/users/{id}/edit")),
            //new Action('delete'),
        ]);
    }

    public function getList()
    {
        return User::all();
    }
}
