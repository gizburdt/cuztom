<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Radios extends Cuztom_Field
{
	var $_supports_bundle		= true;
	
	var $css_classes 			= array( 'cuztom-input' );
	var $data_attributes 		= array( 'default-value' => null );

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );
		
		$this->data_attributes['default-value']  = $this->default_value;
		$this->after							.= '[]';
	}

	function _output( $value )
	{
		$output = '';

		$output .= '<div class="cuztom-checkboxes-wrap" ' . $this->output_data_attributes() . '>';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<input type="radio" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . ( ! empty( $value ) ? ( in_array( $slug, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : checked( $this->default_value, $slug, false ) ) . ' /> ';
					$output .= '<label ' . $this->output_for_attribute( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . '">' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}
}