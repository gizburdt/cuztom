<?php

class Cuztom_Field_Radios extends Cuztom_Field
{	
	function _output( $value )
	{
		$output = '';

		$output .= '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<input type="radio" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? ( in_array( Cuztom::uglify( $slug ), ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : checked( $this->default_value, Cuztom::uglify( $slug ), false ) ) . ' class="cuztom-input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		return $output;
	}
}