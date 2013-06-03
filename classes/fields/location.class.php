<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Location extends Cuztom_Field
{

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->default_value = ( $this->default_value && is_array($this->default_value) ) ? $this->default_value : array('0', '0');
	}

	function _output( $value, $object )
	{
		$output  = '<div class="js-cuztom-location">';
		$output .= '<input type="text" class="cuztom-lat" placeholder="' . __('Latitude', 'cuztom') . '" value="' . ( ! empty( $value ) && array_key_exists( 'lat', $value ) ? $value['lat'] : $this->default_value[0] ) . '" name="cuztom' . $this->pre . '[' . $this->id_name . '][lat]" id="' . $this->pre_id . $this->id_name . $this->after_id . '-lat" />';
		$output .= '<input type="text" class="cuztom-long" placeholder="' . __('Longitude', 'cuztom') . '" value="' . ( ! empty( $value ) && array_key_exists( 'long', $value ) ? $value['long'] : $this->default_value[1] ) . '" name="cuztom' . $this->pre . '[' . $this->id_name . '][long]" id="' . $this->pre_id . $this->id_name . $this->after_id . '-long" />';
		$output .= '<div class="cuztom-map" id="' . $this->pre_id . $this->id_name . $this->after_id . '-map"></div>';
		$output .= '</div>';

		return $output;
	}
}