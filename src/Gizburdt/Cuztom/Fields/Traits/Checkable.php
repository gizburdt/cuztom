<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

trait Checkable
{
    /**
     * Output option
     *
     * @param  string $value
     * @param  string $option
     * @return string
     * @since  3.0
     */
    public function _output_option($value = null, $option)
    {
        return '<input
            type="'  .$this->get_input_type(). '"
            name="'  .$this->get_name(). '"
            id="'    .$this->get_id($option). '"
            class="' .$this->get_css_class(). '"
            value="' .$option. '"'
            .(! Cuztom::is_empty($value) ? checked($value, $option, false) : checked($this->default_value, $option, false)).
            '/>';
    }
}
