<?php

class Cuztom_Field_Text extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	function _output( $value )
	{
		return ( $this->repeatable ? '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' : '' ) . '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input" />' . ( $this->repeatable ? '</li>' : '' );
	}
	
	function _repeatable_output( $value )
	{
		$output = '';
		
		foreach( $value as $item )
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div><input type="text" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" value="' . ( ! empty( $item ) ? $item : $this->default_value ) . '" class="cuztom-input" />' . ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}

	function _ajax_output( $value )
	{
		$output = '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input" />';
		$output .= sprintf( '<a class="cuztom-ajax-save js-cuztom-ajax-save button-secondary" href="#">%s</a>', __( 'Save', CUZTOM_TEXTDOMAIN ) );

		return $output;
	}
}