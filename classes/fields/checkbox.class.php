<?php

class Cuztom_Field_Checkbox extends Cuztom_Field
{	
	function _output( $value )
	{
		return '<input type="checkbox" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $this->default_value, 'on', false ) ) . ' class="cuztom_input" />';
	}

	function save( $post_id, $value )
	{
		$value = empty( $value ) ? '-1' : $value;

		parent::save( $post_id, $value );
	}
}