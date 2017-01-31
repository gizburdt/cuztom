<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

trait Checkable
{
    /**
     * Output option.
     *
     * @param  string $value
     * @param  string $default_value
     * @param  string $option
     * @return string
     */
    public function outputOption($value = null, $default_value = null, $option = null)
    {
        return '<input
            type="'.$this->getInputType().'"
            name="'.$this->getName().'"
            id="'.$this->getId($option).'"
            class="'.$this->getCssClass().'"
            value="'.$option.'"
            '.$this->getDataAttributes().'
            '.$this->maybeChecked($value, $default_value, $option).'/>';
    }

    /**
     * Output checked attribute.
     *
     * @param  mixed  $value
     * @return string
     */
    public function maybeChecked($value = null, $default_value = null, $option = null)
    {
        return ! Cuztom::isEmpty($value)
            ? checked($value, $option, false)
            : checked($default_value, $option, false);
    }
}
