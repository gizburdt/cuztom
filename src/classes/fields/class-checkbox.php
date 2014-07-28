<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Checkbox extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes			= array( 'cuztom-input' );

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
		return '<div class="cuztom-checkbox"><input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id() . '" ' . $this->output_css_class() . ' ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $this->default_value, 'on', false ) ) . ' /></div>' . $this->output_explanation();
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
		return empty( $value ) ? '-1' : $value;
	}
}