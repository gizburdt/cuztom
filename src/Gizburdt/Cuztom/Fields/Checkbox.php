<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Fields\Field;

if (! defined('ABSPATH')) {
    exit;
}

class Checkboc extends Field
{
    public $_supports_bundle       = true;
    public $css_classes            = array( 'cuztom-input' );

    /**
     * Output method
     * @param  mixed $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return '<div class="cuztom-checkbox"><input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id() . '" ' . $this->output_css_class() . ' ' . $this->output_value($value) . ' /></div>' . $this->output_explanation();
    }

    /**
     * Output value
     * @param  mixed $value
     * @return string
     * @since  3.0
     */
    public function output_value($value = null)
    {
        return (! empty($value) ? checked($value, 'on', false) : checked($this->default_value, 'on', false));
    }

    /**
     * Parse value
     * @param  mixed $value
     * @return mixed
     */
    public function parse_value($value)
    {
        return Cuztom::is_empty($value) ? '-1' : $value;
    }
}
