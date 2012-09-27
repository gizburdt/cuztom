<?php

class Cuztom_Field_Select extends Cuztom_Field
{	
	function __construct(  )
	{
		$this->repeatable ? $this->generate_repeatable_output() : $this->generate_output();
	}
	
	function generate_output()
	{
		$this->output = ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom_input" />' . ( $this->repeatable ? '</li>' : '' );
	}
	
	function generate_repeatable_output()
	{
		foreach( $value as $item )
		{
			$this->output .= '<li class="cuztom_field"><div class="handle_repeatable"></div><input type="text" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" value="' . ( ! empty( $item ) ? $item : $this->default_value ) . '" class="cuztom_input" />' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}
	}	
}