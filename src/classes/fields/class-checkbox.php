<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Checkbox extends Cuztom_Field
{
    var $_supports_bundle       = true;
    var $css_classes            = array( 'cuztom-input' );

    /**
     * Output method
     * @param  mixed $value
     * @return string
     * @since  2.4
     */
    function _output($value = null)
    {
        return '<div class="cuztom-checkbox"><input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id() . '" ' . $this->output_css_class() . ' ' . $this->output_value($value) . ' /></div>' . $this->output_explanation();
    }

    /**
     * Output value
     * @param  mixed $value
     * @return string
     * @since  3.0
     */
    function output_value($value = null)
    {
        return ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $this->default_value, 'on', false ) );
    }

    /**
     * Parse value
     * @param  mixed $value
     * @return mixed
     */
    function parse_value($value)
    {
        return Cuztom::is_empty( $value ) ? '-1' : $value;
    }
}