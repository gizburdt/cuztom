<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes 			= array( 'cuztom-input' );
	
	function _output( $value, $object )
	{
		$output = '<select ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_classes() . '>';
			if( isset( $this->args['option_none'] ) && $this->args['option_none'] )
				$output .= '<option value="0" ' . ( empty( $value ) ? 'selected="selected"' : '' ) . '>' . __( 'None', 'cuztom' ) . '</option>';				

			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<option value="' . $slug . '" ' . ( ! empty( $value ) ? selected( $slug, $value, false ) : selected( $this->default_value, $slug, false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select>';

		return $output;
	}
}