<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Yesno extends Cuztom_Field
{
	var $_supports_bundle		= true;
	
	var $css_classes 			= array( 'cuztom-input' );

	function _output( $value )
	{
		$output = '';

		$output .= '<div class="cuztom-checkbox-wrap">';
			$output .= '<input type="radio" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_yes' ) . ' ' . $this->output_css_class() . ' value="yes" ' . ( ! empty( $value ) ? checked( $value, 'yes', false ) : checked( $this->default_value, 'yes', false ) ) . ' /> ';
			$output .= sprintf( '<label class="cuztom-label" for="%s_yes">%s</label>', $this->id, __( 'Yes', 'cuztom' ) );
			$output .= '<br />';
			$output .= '<input type="radio" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_no' ) . ' ' . $this->output_css_class() . ' value="no" ' . ( ! empty( $value ) ? checked( $value, 'no', false ) : checked( $this->default_value, 'no', false ) ) . ' /> ';
			$output .= sprintf( '<label class="cuztom-label" for="%s_no">%s</label>', $this->id, __( 'No', 'cuztom' ) );
		$output .= '</div>';

		$output .= $this->output_explanation();
		
		return $output;
	}
}