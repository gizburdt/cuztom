<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

trait Arrayable
{
    /**
     * Parse value.
     *
     * @param string $value
     *
     * @return string
     */
    public function parse_value($value)
    {
        return $value;
    }
}
