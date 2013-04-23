<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Color extends Cuztom_Field
{
	var $_supports_ajax			= true;
	var $_supports_bundle		= false;
	
	function _output( $value, $object )
	{
		return '<input type="text" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" class="js-cuztom-colorpicker cuztom-colorpicker colorpicker cuztom-input" value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
	}	
}