<?php

class Cuztom_Field_Date extends Cuztom_Field
{
	function _output( $value )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom_datepicker datepicker cuztom_input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . ( isset( $this->options['date_format'] ) ? 'data-date-format="' . $this->options['date_format'] . '"' : '' ) . ' />';
	}
}