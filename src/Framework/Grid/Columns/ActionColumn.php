<?php

namespace SDLX\Core\Framework\Grid\Columns;

use Illuminate\Database\Eloquent\Model;
use SDLX\Core\Framework\Grid\Action;

/**
 * Grid Action Column
 */
class ActionColumn extends Column
{
    /**
     * @var Action[] The array of Actions
     */
    protected $actions;

    /**
     * @param Action[] $actions Array with Action objects
     * @param string|null $label Optional label (defaults to "Action")
     */
    public function __construct(array $actions, $label = null)
    {
        parent::__construct(null, $label ?? _('Action'));

        $this->actions = $actions;
    }

    /**
     * @inheritDoc
     */
    public function render(Model $model)
    {
        $out = [];

        foreach ($this->actions as $action) {
            $out[] = '<a class="grid-action" data-action="'. $action->getCode() .'" href="'. ($action->hasUrl() ? $action->getUrl($model) : 'javascript:void(0);') .'">'. $action->getLabel() .'</a>';
        }

        return implode(' ', $out);
    }
}
