<?php

class Cuztom_Field_Textarea extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	
	function _output( $value )
	{
		return ( $this->repeatable ? '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' : '' ) . '<textarea name="cuztom' . $this->pre . '[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . '" id="' . $this->id_name . '" class="cuztom-input">' . ( ! empty( $value ) ? $value : $this->default_value ) . '</textarea>' . ( $this->repeatable ? '</li>' : '' );	
	}
	
	function _repeatable_output( $value )
	{
		$output = '';

		foreach( $value as $item )
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div><textarea name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" class="cuztom-input">' . ( ! empty( $item ) ? $item : $this->default_value ) . '</textarea>' . ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}
}