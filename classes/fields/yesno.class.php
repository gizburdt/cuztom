<?php

class Cuztom_Field_Yesno extends Cuztom_Field
{
	function _output( $value )
	{
		$output = '<div class="cuztom_checked_wrap cuztom_padding_wrap">';
			$output .= '<input type="radio" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '_yes" value="yes" ' . ( ! empty( $value ) ? checked( $value, 'yes', false ) : checked( $this->default_value, 'yes', false ) ) . ' class="cuztom_input" /> ';
			$output .= sprintf( '<label for="%s_yes">%s</label>', $this->id_name, __( 'Yes', CUZTOM_TEXTDOMAIN ) );
			$output .= '<br />';
			$output .= '<input type="radio" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '_no" value="no" ' . ( ! empty( $value ) ? checked( $value, 'no', false ) : checked( $this->default_value, 'no', false ) ) . ' class="cuztom_input" /> ';
			$output .= sprintf( '<label for="%s_no">%s</label>', $this->id_name, __( 'No', CUZTOM_TEXTDOMAIN ) );
		$output .= '</div>';
		
		return $output;
	}
}