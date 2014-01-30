<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Color extends Cuztom_Field
{
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes			= array( 'js-cuztom-colorpicker', 'cuztom-colorpicker', 'colorpicker', 'cuztom-input' );
}