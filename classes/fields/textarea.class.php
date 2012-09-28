<?php

class Cuztom_Field_Textarea extends Cuztom_Field
{
	function _output( $value )
	{
		return ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<textarea name="cuztom' . $this->pre . '[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . '" id="' . $this->id_name . '" class="cuztom_input">' . ( ! empty( $value ) ? $value : $this->default_value ) . '</textarea>' . ( $this->repeatable ? '</li>' : '' );	
	}
	
	function _repeatable_output( $value )
	{
		$output = '';

		foreach( $value as $item )
		{
			$output .= '<li class="cuztom_field"><div class="handle_repeatable"></div><textarea name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" class="cuztom_input">' . ( ! empty( $item ) ? $item : $this->default_value ) . '</textarea>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}

		return $output;
	}
}