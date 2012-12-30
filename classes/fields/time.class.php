<?php

class Cuztom_Field_Time extends Cuztom_Field
{
	function _output( $value )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="js-cuztom-timepicker cuztom-timepicker timepicker cuztom-input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . ( isset( $this->options['time_format'] ) ? 'data-time-format="' . $this->options['time_format'] . '"' : '' ) . ' />';
	}
}