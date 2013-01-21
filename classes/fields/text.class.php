<?php

class Cuztom_Field_Text extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	function _output( $value )
	{
		return '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
	
	function _repeatable_output( $value )
	{
		$this->after = '[]';
		$output = '';
		
		if( is_array( $value ) )
		{
			foreach( $value as $item )
			{
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $item ) . ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
			}
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $value ) . '</li>';
		}

		return $output;
	}
}