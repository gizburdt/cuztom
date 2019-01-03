<?php

namespace Gizburdt\Cuztom;

Guard::blockDirectAccess();

class Request
{
    /**
     * Attributes.
     *
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
        $this->attributes = isset($attributes['cuztom']) ? $attributes['cuztom'] : $attributes;
    }

    /**
     * Getter.
     *
     * @param string $attribute
     *
     * @return string|null
     */
    public function get($attribute)
    {
        return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
    }

    /**
     * Get all attributes.
     *
     * @return array
     */
    public function all()
    {
        return $this->attributes;
    }
}
