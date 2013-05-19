<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Text extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_bundle		= true;
	var $_supports_ajax			= true;

	var $css_classes			= array( 'cuztom-input' );

	function save( $post_id, $value, $meta_type )
	{
		$value = htmlspecialchars( $value );

		parent::save( $post_id, $value, $meta_type );
	}
}