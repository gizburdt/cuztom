<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Textarea extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;
	
	function _output( $value, $object )
	{
		return '<textarea ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . '>' . ( ! empty( $value ) ? $value : $this->default_value ) . '</textarea>' . $this->output_explanation();
	}
}