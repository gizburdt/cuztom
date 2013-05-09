<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Time extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-timepicker', 'cuztom-timepicker', 'timepicker', 'cuztom-input' );
	var $data_attributes		= array( 'time-format' => null );
}