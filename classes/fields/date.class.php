<?php

class Cuztom_Field_Date extends Cuztom_Field
{
	var $_supports_ajax			= true;

	function _output( $value )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="js-cuztom-datepicker cuztom-datepicker datepicker cuztom-input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . ( isset( $this->args['date_format'] ) ? 'data-date-format="' . $this->args['date_format'] . '"' : '' ) . ' />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}