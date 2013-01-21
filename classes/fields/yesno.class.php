<?php

class Cuztom_Field_Yesno extends Cuztom_Field
{
	function _output( $value )
	{
		$output = '';

		$output .= '<div class="cuztom-checkbox-wrap">';
			$output .= '<input type="radio" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '_yes" value="yes" ' . ( ! empty( $value ) ? checked( $value, 'yes', false ) : checked( $this->default_value, 'yes', false ) ) . ' class="cuztom-input" /> ';
			$output .= sprintf( '<label class="cuztom-label" for="%s_yes">%s</label>', $this->id_name, __( 'Yes', 'cuztom' ) );
			$output .= '<br />';
			$output .= '<input type="radio" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '_no" value="no" ' . ( ! empty( $value ) ? checked( $value, 'no', false ) : checked( $this->default_value, 'no', false ) ) . ' class="cuztom-input" /> ';
			$output .= sprintf( '<label class="cuztom-label" for="%s_no">%s</label>', $this->id_name, __( 'No', 'cuztom' ) );
		$output .= '</div>';
		
		return $output;
	}
}