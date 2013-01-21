<?php

class Cuztom_Field_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	
	function _output( $value )
	{
		$output = '<select name="cuztom[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" class="cuztom-input">';
			if( isset( $this->args['option_none'] ) && $this->args['option_none'] )
				$output .= '<option value="0" ' . ( empty( $value ) ? 'selected="selected"' : '' ) . '>' . __( 'None', 'cuztom' ) . '</option>';				

			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? selected( Cuztom::uglify( $slug ), $value, false ) : selected( $this->default_value, Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select>';

		return $output;
	}
	
	function _repeatable_output( $value )
	{
		$this->after = '[]';
		$output = '';

		if( is_array( $value ) )
		{
			foreach( $value as $item )
			{
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $item ) . '</li>';
			}
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $value ) . '</li>';
		}

		return $output;
	}
}