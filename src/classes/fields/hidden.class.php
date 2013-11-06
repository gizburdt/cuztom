<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Hidden extends Cuztom_Field
{
	var $css_classes			= array( 'cuztom-input' );

	function _output( $value )
	{
		return '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( strlen( $value ) > 0 ? $value : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
	}
}