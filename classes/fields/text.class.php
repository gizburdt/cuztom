<?php

class Cuztom_Field_Text extends Cuztom_Field
{	
	function _output( $value )
	{
		return ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $this->value ) ? $this->value : $this->default_value ) . '" class="cuztom_input" />' . ( $this->repeatable ? '</li>' : '' );
	}
	
	function _repeatable_output( $value )
	{
		foreach( $value as $item )
		{
			return '<li class="cuztom_field"><div class="handle_repeatable"></div><input type="text" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" value="' . ( ! empty( $item ) ? $item : $this->default_value ) . '" class="cuztom_input" />' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}
	}
}