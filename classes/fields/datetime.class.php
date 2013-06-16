<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Datetime extends Cuztom_Field
{
	var $_supports_ajax			= true;

	var $css_classes			= array( 'js-cuztom-datetimepicker', 'cuztom-datetimepicker', 'datetimepicker', 'cuztom-input' );
	var $data_attributes		= array( 'time-format' => null, 'date-format' => null );

	function _output( $value, $object )
	{
		return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? ( isset( $this->args['date_format'] ) && isset( $this->args['time_format'] ) ? date( $this->args['date_format'] . ' ' . $this->args['time_format'], $value ) : date( 'm/d/Y H:i', $value ) ) : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation(); }

	function save( $post_id, $value, $meta_type )
	{
		$value = strtotime( $value );

		return parent::save( $post_id, $value, $meta_type );
	}
}