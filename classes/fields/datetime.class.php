<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Datetime extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-datetimepicker', 'cuztom-datetimepicker', 'datetimepicker', 'cuztom-input' );
	var $data_attributes		= array( 'time-format' => null, 'date-format' => null );
}