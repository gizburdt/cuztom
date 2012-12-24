<?php

class Cuztom_Field_Select extends Cuztom_Field
{	
	function _output( $value )
	{
		$output = ( $this->repeatable ? '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' : '' ) . '<select name="cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . '" id="' . $this->id_name . '" class="cuztom-input">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? selected( Cuztom::uglify( $slug ), $value, false ) : selected( $this->default_value, Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select>' . ( $this->repeatable ? '</li>' : '' );

		return $output;
	}
	
	function _repeatable_output( $value )
	{
		$output = '';

		foreach( $value as $item )
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div><select name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" class="cuztom-input">';
				if( is_array( $this->options ) )
				{
					foreach( $this->options as $slug => $name )
					{
						$output .= '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $item ) ? selected( Cuztom::uglify( $slug ), $item, false ) : selected( $this->default_value, Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
					}
				}
			$output .= '</select>' . ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}
}