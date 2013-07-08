<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Url extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-url', 'cuztom-url', 'cuztom-input' );

	function _output( $value )
	{
		
	}
}