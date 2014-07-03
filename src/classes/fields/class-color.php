<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Color extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes			= array( 'js-cz-colorpicker', 'cuztom-colorpicker', 'colorpicker', 'cuztom-input' );
}