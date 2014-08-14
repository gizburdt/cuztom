<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Time extends Cuztom_Field_Datetime
{
	/**
	 * Feature support
	 */
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes			= array( 'js-cztm-timepicker', 'cuztom-timepicker', 'timepicker', 'cuztom-input' );
	var $data_attributes		= array( 'time-format' => null );

	/**
	 * Constructs Cuztom_Field_Time
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3.3
	 *
	 */
	function __construct( $field )
	{
		parent::__construct( $field );

		$this->data_attributes['time-format'] = $this->parse_date_format( isset( $this->args['time_format'] ) ? $this->args['time_format'] : 'H:i' );
	}

	/**
	 * Output method
	 *
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.4
	 *
	 */
	function _output( $value = null )
	{
		return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? ( isset( $this->args['time_format'] ) ? date( $this->args['time_format'], $value ) : date( 'H:i', $value ) ) : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
	}

	/**
	 * Parse value
	 *
	 * @param 	string 		$value
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8
	 *
	 */
	function save_value( $value )
	{
		return strtotime( $value );
	}
}