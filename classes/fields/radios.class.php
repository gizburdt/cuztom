<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Radios extends Cuztom_Field
{
	var $css_classes 			= array( 'cuztom-input' );

	function _output( $value )
	{
		$output = '';

		$output .= '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<input type="radio" ' . $this->output_name( 'cuztom[' . $this->id . '][]' ) . ' ' . $this->output_id( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . ( ! empty( $value ) ? ( in_array( $slug, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : checked( $this->default_value, $slug, false ) ) . ' /> ';
					$output .= '<label ' . $this->output_for_attribute( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . '">' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}
}