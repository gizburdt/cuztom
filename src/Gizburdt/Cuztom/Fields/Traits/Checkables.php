<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

trait Checkables
{
    /**
     * Output option.
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
            type="'.$this->get_input_type().'"
            name="'.$this->get_name().'"
            id="'.$this->get_id($option).'"
            class="'.$this->get_css_class().'"
            value="'.$option.'"
            '.$this->get_data_attributes().'
            '.$this->maybe_checked($value, $default_value, $option).'/>';
    }

    /**
     * Output checked attribute.
     *
     * @param  mixed  $value
     * @return string
     * @since  3.0
     */
    public function maybe_checked($value = null, $default_value = null, $option = null)
    {
        if (is_array($value) && in_array($option, $value)) {
            return 'checked="checked"';
        }

        return false;
    }
}
