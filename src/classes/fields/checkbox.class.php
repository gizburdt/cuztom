<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Checkbox extends Cuztom_Field
{
	var $_supports_bundle		= true;
	var $css_classes			= array( 'cuztom-input' );

	function _output( $value )
	{
		return '<div class="cuztom-checkbox-wrap"><input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id() . '" ' . $this->output_css_class() . ' ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $this->default_value, 'on', false ) ) . ' /></div>' . $this->output_explanation();
	}

	function save_value( $value )
	{
		return empty( $value ) ? '-1' : $value;
	}
}