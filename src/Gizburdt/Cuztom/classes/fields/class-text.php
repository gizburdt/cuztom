<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Text extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	/**
	 * Attributes
	 */
	var $css_classes			= array( 'cuztom-input', 'cuztom-input-text' );

	/**
	 * Parse value
	 *
	 * @param 	string 		$value
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8
	 *
	 */
	function parse_value( $value )
	{
		if( is_array( $value ) ) {
			array_walk_recursive( $value, array( &$this, 'do_htmlspecialchars' ) );
		} else {
			$value = htmlspecialchars( $value );
		}

		return $value;
	}

	/**
	 * Applies htmlspecialchars to $value
	 *
	 * @param 	string 		$value
	 *
	 * @author  Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function do_htmlspecialchars( &$value )
	{
		$value = htmlspecialchars( $value );
	}
}