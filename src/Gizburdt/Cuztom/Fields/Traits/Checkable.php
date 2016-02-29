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
     * @param  string $default_value
     * @param  string $option
     * @return string
     * @since  3.0
     */
    public function _output_option($value = null, $default_value = null, $option = null)
    {
        return '<input
            type="'  .$this->get_input_type().'"
            name="'  .$this->get_name().'"
            id="'    .$this->get_id($option).'"
            class="' .$this->get_css_class().'"
            value="' .$option. '"
            '        .$this->output_checked($value, $default_value). '/>';
    }

    /**
     * Output checked attribute
     *
     * @param  mixed $value
     * @return string
     * @since  3.0
     */
    public function output_checked($value = null, $default_value = null)
    {
        return (! Cuztom::is_empty($value)
            ? checked($value, 'on', false)
            : checked($default_value, 'on', false));
    }

    /**
     * Parse value
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function parse_value($value)
    {
        return Cuztom::is_empty($value) ? '-1' : $value;
    }
}
