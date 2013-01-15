<?php

class Cuztom_Field_Datetime extends Cuztom_Field
{
	var $_supports_ajax			= true;
	
	function _output( $value )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="js-cuztom-datetimepicker cuztom-datetimepicker datetimepicker cuztom-input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . ( isset( $this->args['time_format'] ) ? 'data-time-format="' . $this->args['time_format'] . '"' : '' ) . ' ' . ( isset( $this->args['date_format'] ) ? 'data-date-format="' . $this->args['date_format'] . '"' : '' ) . ' />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}