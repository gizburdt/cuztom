<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Slider extends Cuztom_Field
{
	function _output( $value )
	{
		//return '<input type="text" name="cuztom' . $this->pre . '[' . $this->id . ']' . $this->after . '" id="' . $this->id . '" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" class="cuztom-input js-slider" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}