<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Hidden extends Cuztom_Field
{
	function _output( $value, $object )
	{
		return '<input type="hidden" name="cuztom' . $this->pre . '[' . $this->id_name . ']" id="' . $this->id_name . '" value="' . $this->default_value . '" class="cuztom-input" />';
	}
}