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
     * @since 3.0
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
     * @since  3.0
     */
    public function get($attribute)
    {
        return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
    }
}
