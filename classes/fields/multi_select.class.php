<?php

class Cuztom_Field_Multi_Select extends Cuztom_Field
{	
	function _output( $value )
	{
		$output = '<select name="cuztom[' . $this->id_name . '][]' . $this->after . '" id="' . $this->id_name . '" class="cuztom-input" multiple="true">';
			if( isset( $this->args['option_none'] ) && $this->args['option_none'] )
				$output .= '<option value="0" ' . ( is_array( $value ) ? ( in_array( 0, $value ) ? 'selected="selected"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( 0, $this->default_value ) ? 'selected="selected"' : '' ) ) . '>' . __( 'None', 'cuztom' ) . '</option>';

			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( is_array( $value ) ? ( in_array( $slug, $value ) ? 'selected="selected"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $slug, $this->default_value ) ? 'selected="selected"' : '' ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select>';

		return $output;
	}

	function save( $post_id, $value, $context )
	{
		$value = empty( $value ) ? '-1' : $value;

		parent::save( $post_id, $value, $context );
	}
}