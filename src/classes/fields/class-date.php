<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Date extends Cuztom_Field_Datetime
{
    var $_supports_ajax   = true;
    var $_supports_bundle = true;
    var $css_classes      = array( 'js-cztm-datepicker', 'cuztom-datepicker', 'datepicker', 'cuztom-input' );
    var $data_attributes  = array( 'date-format' => null );

    /**
     * Constructs Cuztom_Field_Date
     * @param array $field
     * @since 0.3.3
     */
    function __construct( $field )
    {
        parent::__construct( $field );

        $this->data_attributes['date-format'] = $this->parse_date_format( isset( $this->args['date_format'] ) ? $this->args['date_format'] : 'm/d/Y' );
    }

    /**
     * Output method
     * @param  mixed $value
     * @return string
     * @since  2.4
     */
    function _output( $value = null )
    {
        return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? ( isset( $this->args['date_format'] ) ? date( $this->args['date_format'], $value ) : date( 'm/d/Y', $value ) ) : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
    }

    /**
     * Parse value
     * @param  mixed $value
     * @return string
     * @since  2.8
     */
    function parse_value( $value )
    {
        return strtotime( $value );
    }
}