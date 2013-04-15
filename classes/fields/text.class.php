<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Text extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	function _output( $value, $object )
	{
		return '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}