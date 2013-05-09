<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Date extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-datepicker', 'cuztom-datepicker', 'datepicker', 'cuztom-input' );
	var $data_attributes 		= array( 'date-format' => null );
}