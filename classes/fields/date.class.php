<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Date extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-datepicker', 'cuztom-datepicker', 'datepicker', 'cuztom-input' );
	var $data_attributes 		= array( 'date-format' => null );

	function _output( $value )
	{
		return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? ( isset( $this->args['date_format'] ) ? date( $this->parse_date_format( $this->args['date_format'] ), $value ) : date( 'm/d/Y', $value ) ) : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
	}

	function save( $post_id, $value )
	{
		$value = strtotime( $value );

		return parent::save( $post_id, $value );
	}

	function parse_date_format( $date )
	{
		return $date;
	}
}