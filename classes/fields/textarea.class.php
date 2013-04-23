<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Textarea extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;
	
	function _output( $value, $object )
	{
		return '<textarea name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" class="cuztom-input">' . ( ! empty( $value ) ? $value : $this->default_value ) . '</textarea>' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}
}