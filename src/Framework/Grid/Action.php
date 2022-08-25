<?php

namespace SDLX\Core\Framework\Grid;

use Illuminate\Database\Eloquent\Model;

/**
 * Grid action class
 */
class Action
{
    /**
     * @var string Action code
     */
    private $code;

    /**
     * @var string|null Action URL (optional)
     */
    private $url;

    /**
     * @var string|null Button/link label
     */
    private $label;

    /**
     * @param string $code
     * @param string|null $url
     * @param string|null $label
     */
    public function __construct($code, $url = null, $label = null)
    {
        $this->code = $code;
        $this->url = $url;
        $this->label = $label;
    }

    /**
     * Is this Action a URL?
     *
     * @return bool
     */
    public function hasUrl()
    {
        return $this->url !== null;
    }

    /**
     * Get URL
     *
     * @param Model $model
     * @return string|null
     */
    public function getUrl(Model $model)
    {
        return str_replace('{id}', $model->id, $this->url);
    }

    /**
     * Get Action label
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label ?? $this->getDefaultLabel();
    }

    /**
     * Get Action default label, if it was not provided
     *
     * @return string
     */
    private function getDefaultLabel()
    {
        switch ($this->code)
        {
            case 'edit':
                return _('Edit');
            case 'delete':
                return _('Delete');
            case 'view':
                return _('View');
            default:
                return mb_strtoupper($this->code);
        }
    }

    /**
     * Get Action code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
