<?php

namespace SDLX\Core\Foundation\Grid;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var string Filter name (used for the form input name)
     */
    protected string $name;

    /**
     * @var string Filter label
     */
    protected string $label;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @inheritDoc
     */
    public function getModelName(): string
    {
        return 'active_filters.' . $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

}
