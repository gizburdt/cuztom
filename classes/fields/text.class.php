<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Text extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	var $css_classes			= array( 'cuztom-input' );

	function save_value( $value )
	{
		if( is_array( $value ) )
			array_walk_recursive( $value, array( &$this, 'do_htmlspecialchars' ) );
		else
			$value = htmlspecialchars( $value );

		return $value;
	}

	function do_htmlspecialchars( &$value )
	{
		$value = htmlspecialchars( $value );
	}
}