<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Textarea extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	/**
	 * Attributes
	 */
	var $css_classes 			= array( 'cuztom-input', 'cuztom-textarea' );
	
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
		return '<textarea ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . '>' . ( strlen( $value ) > 0 ? $value : $this->default_value ) . '</textarea>' . $this->output_explanation();
	}
}