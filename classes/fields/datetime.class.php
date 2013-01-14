<?php

class Cuztom_Field_Datetime extends Cuztom_Field
{
	var $_supports_ajax			= true;
	
	function _output( $value )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="js-cuztom-datetimepicker cuztom-datetimepicker datetimepicker cuztom-input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . ( isset( $this->options['time_format'] ) ? 'data-time-format="' . $this->options['time_format'] . '"' : '' ) . ' ' . ( isset( $this->options['date_format'] ) ? 'data-date-format="' . $this->options['date_format'] . '"' : '' ) . ' />';
	}
}