<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Request
{
    /**
     * Attributes.
     * @var array
     */
    protected $attributes;

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes['cuztom'];
    }

    /**
     * Getter.
     *
     * @param  string      $attribute
     * @return string|null
     */
    public function __get($attribute)
    {
        return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
    }
}
