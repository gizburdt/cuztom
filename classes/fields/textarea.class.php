<?php

class Cuztom_Field_Textarea extends Cuztom_Field
{	
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );
	}
	
	function generate_output()
	{
		$this->output = ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<textarea name="cuztom' . $pre . '[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . '" id="' . $this->id_name . '" class="cuztom_input">' . ( ! empty( $value ) ? $value : $this->default_value ) . '</textarea>' . ( $this->repeatable ? '</li>' : '' );
	}
	
	function generate_repeatable_output()
	{
		/*
		foreach( $value as $item )
		{
			$this->output = '<li class="cuztom_field"><div class="handle_repeatable"></div><textarea name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '" class="cuztom_input">' . ( ! empty( $item ) ? $item : $field['default_value'] ) . '</textarea>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}
		*/
	}	
}