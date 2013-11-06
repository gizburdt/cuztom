<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes 			= array( 'cuztom-input cuztom-select' );
	var $data_attributes 		= array( 'default-value' => null );

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );
		
		$this->data_attributes['default-value'] = $this->default_value;
	}
	
	function _output( $value )
	{
		$output = '<select ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' ' . $this->output_data_attributes() . '>';
			if( isset( $this->args['show_option_none'] ) )
				$output .= '<option value="0" ' . ( empty( $value ) ? 'selected="selected"' : '' ) . '>' . $this->args['show_option_none'] . '</option>';				

			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<option value="' . $slug . '" ' . ( ! empty( $value ) ? selected( $slug, $value, false ) : selected( $this->default_value, $slug, false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select>';

		$output .= $this->output_explanation();

		return $output;
	}
}