<?php

namespace Ocelot\Core\Foundation;

use Ocelot\Core\Framework\Grid\Columns\Column;

/**
 * Abstract Grid Definition that every Grid should implement
 */
abstract class AbstractGridDefinition
{
    /**
     * @var Column[] Column array
     */
    protected $columns;

    /**
     * @var int Records per page to show
     */
    protected $per_page = 100;

    /**
     * Get columns array
     *
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
