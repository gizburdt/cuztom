<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Date extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-datepicker', 'cuztom-datepicker', 'datepicker', 'cuztom-input' );
	var $data_attributes 		= array( 'date-format' => null );

	function _output( $value, $object )
	{
		return '<input type="text" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . $this->after_id . '" ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? $value : $this->default_value ) . '" ' . $this->output_data_attributes() ) . ' />' . $this->output_explanation();
	}
}