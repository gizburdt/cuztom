<?php

class Cuztom_Field_Text extends Cuztom_Field
{
	var $this->name;
    var $this->label;
    var $this->description;
	var $this->hide;
	var $this->default_value;
	var $this->options;
	var $this->repeatable;
	var $this->show_column;
	var $this->output;
	
	function __construct(  )
	{
		if( $field['repeatable'] && is_array( $value ) )
			
		else
		{
			
		}
	}
	
	function generate_output()
	{
		$this->output = ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<input type="text" name="cuztom' . $pre . '[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . $after . '" id="' . $field_id_name . '" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" class="cuztom_input" />' . ( $field['repeatable'] ? '</li>' : '' );
	}
	
	function generate_repeatable_output()
	{
		foreach( $value as $item )
		{
			$this->output .= '<li class="cuztom_field"><div class="handle_repeatable"></div><input type="text" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '" value="' . ( ! empty( $item ) ? $item : $field['default_value'] ) . '" class="cuztom_input" />' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}
	}
	
	function output()
	{
		return $this->output;
	}
	
	
}
