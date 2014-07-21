<?php
if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Location extends Cuztom_Field {
    /**
     * Feature support
     */
    var $_supports_repeatable   = true;
    var $_supports_bundle       = true;
    var $_supports_ajax     = true;

    /**
     * Attributes
     */
    var $css_classes        = array( 'cuztom-input', 'cuztom-location' );

    /**
     * Output method
     *
     * @return  string
     *
     * @author  Ante Primorac
     * @since   3.0
     *
     */
    function _output( $value = null ) {
        $latitude = '';
        $longitude = '';
        $latitude_after_name = $this->after_name . '[latitude]';
        $longitude_after_name = $this->after_name . '[longitude]';
        $default_value = array();

        if( empty( $this->default_value ) ) {
            $default_value = array(
                'latitude' => 52,
                'longitude' => 0
            );
        }

        if( !isset( $this->default_value['latitude'] ) ) {
            $default_value['latitude'] = 52;
        }
        else {
            $default_value['latitude'] = $this->parse_latitude( $this->default_value['latitude'] );
        }

        if( !isset( $this->default_value['longitude'] ) ) {
            $default_value['longitude'] = 0;
        }
        else {
            $default_value['longitude'] = $this->parse_latitude( $this->default_value['longitude'] );
        }

        if( !empty( $value ) && isset( $value['latitude'] ) ) {
            $latitude = $this->parse_latitude( $value['latitude'], $default_value['latitude'] );
        }
        else {
            $latitude = $default_value['latitude'];
        }

        if( !empty( $value ) && isset( $value['longitude'] ) ) {
            $longitude = $this->parse_longitude( $value['longitude'], $default_value['longitude'] );
        }
        else {
            $longitude = $default_value['longitude'];
        }

        $output = '';

        $this->after_name = $latitude_after_name;
        $output .= '<input type="text" value="' . $latitude . '" ' . $this->output_name() . ' data-field-id="' . $this->before_id . $this->id . $this->after_id . '" data-default-value="' . $default_value['latitude'] . '" ' . $this->output_css_class( array( 'cuztom-location-latitude' ) ) . ' placeholder="Latitude" />';

        $this->after_name = $longitude_after_name;
        $output .= ' ';
        $output .= '<input type="text" value="' . $longitude . '" ' . $this->output_name() . ' data-field-id="' . $this->before_id . $this->id . $this->after_id . '" data-default-value="' . $default_value['longitude'] . '" ' . $this->output_css_class( array( 'cuztom-location-longitude' ) ) . ' placeholder="Longitude" />';

        $output .= ' ';
        $output .= '<a class="button-secondary button button-small cuztom-button js-cz-default-location" href="javascript:void(null)" data-field-id="' . $this->before_id . $this->id . $this->after_id . '" >' . __( 'Default', 'cuztom' ) . ' </a>';

        $output .= '<div ' . $this->output_css_class( array( 'cuztom-location-map' ) ) . ' data-field-id="' . $this->before_id . $this->id . $this->after_id . '"></div>';

        $output .= $this->output_explanation();

        return $output;
    }

    /**
     * Parse latitude
     *
     * @return  float
     *
     * @author  Ante Primorac
     * @since   3.0
     *
     */
    function parse_latitude( $latitude, $default = 52 ) {
        $latitude = floatval( $latitude );
        if( abs( $latitude ) > 90 ) {
            $latitude = $default;
        }

        return $latitude;
    }

    /**
     * Parse longitude
     *
     * @return  float
     *
     * @author  Ante Primorac
     * @since   3.0
     *
     */
    function parse_longitude( $longitude, $default = 0 ) {
        $longitude = floatval( $longitude );
        if( abs( $longitude ) > 180 ) {
            $longitude = $default;
        }

        return $longitude;
    }
}