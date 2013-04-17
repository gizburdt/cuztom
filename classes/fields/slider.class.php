<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Slider extends Cuztom_Field
{
	function _output( $value, $object )
	{
		return 'Slider';

		//return '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}