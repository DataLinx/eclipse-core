<?php

namespace Eclipse\Core\Framework\Grid\Columns;

use Eclipse\Core\Framework\Grid\Action;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Grid Action Column
 */
class ActionColumn extends Column
{
    public bool $sortable = false;

    /**
     * @var Action[] The array of Actions
     */
    protected array $actions;

    /**
     * @param  Action[]  $actions Array with Action objects
     * @param  string|null  $label Optional label (defaults to "Action")
     */
    public function __construct(array $actions, ?string $label = null)
    {
        parent::__construct('_action', $label ?? _('Action'));

        $this->actions = $actions;
    }

    /**
     * {@inheritDoc}
     */
    public function render(Model $object): string
    {
        $out = [];

        foreach ($this->actions as $action) {
            $out[] = '<a class="btn btn-secondary btn-sm grid-action" data-action="'.$action->getCode().'" href="'.($action->hasUrl() ? $action->getUrl($object) : 'javascript:void(0);').'">'.$action->getLabel().'</a>';
        }

        return implode(' ', $out);
    }

    /**
     * {@inheritDoc}
     */
    public function setSortable(bool $sortable): Column
    {
        throw new InvalidArgumentException('Action column cannot be sortable');
    }
}
