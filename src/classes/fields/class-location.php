<?php
if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Location extends Cuztom_Field {
    /**
     * Feature support
     */
    var $_supports_repeatable   = true;
    var $_supports_bundle       = true;
    var $_supports_ajax         = true;

    /**
     * Attributes
     */
    var $default_value          = array();
    var $css_classes            = array( 'cuztom-input', 'cuztom-location' );

    /**
     * Constructs Cuztom_Field_Location
     *
     * @author  Gijs Jorissen
     * @since   0.3.3
     *
     */
    function __construct( $field )
    {
        parent::__construct( $field );

        $this->default_value = array_merge(
            array(
                'latitude'      => 52,
                'longitude'     => 0
            ),
            $this->default_value
        );

        $this->default_value['latitude']    = $this->parse_latitude( $this->default_value['latitude'] );
        $this->default_value['longitude']   = $this->parse_longitude( $this->default_value['longitude'] );
    }

    /**
     * Output method
     *
     * @return  string
     *
     * @author  Ante Primorac
     * @since   3.0
     *
     */
    function _output( $value = null ) 
    {
        $latitude           = ( isset( $value['latitude'] ) ) ? $this->parse_latitude( $value['latitude'], $this->default_value['latitude'] ) : $this->default_value['latitude'];
        $longitude          = ( isset( $value['longitude'] ) ) ? $this->parse_longitude( $value['longitude'], $this->default_value['longitude'] ) : $this->default_value['longitude'];
        $output             = '';

        foreach( array( 'latitude', 'longitude' ) as $scale ) {
            $this->after_name .= '[' . $scale . ']';
            $value = $scale == 'latitude' ? $latitude : $longitude;

            $output .= '<input type="text" value="' . $latitude . '" ' . $this->output_name() . ' data-field-id="' . $this->before_id . $this->id . $this->after_id . '" data-default-value="' . $this->default_value['latitude'] . '" ' . $this->output_css_class( array( 'cuztom-location-latitude' ) ) . ' placeholder="Latitude" /> ';
        }

        $output .= '<a class="button-secondary button button-small cuztom-button js-cz-location-default" href="#" data-field-id="' . $this->before_id . $this->id . $this->after_id . '" >' . __( 'Default', 'cuztom' ) . ' </a>';
        $output .= '<div class="js-cz-location-map cuztom-location-map" data-field-id="' . $this->before_id . $this->id . $this->after_id . '"></div>';
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
    function parse_latitude( $latitude, $default = 52 ) 
    {
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
    function parse_longitude( $longitude, $default = 0 ) 
    {
        $longitude = floatval( $longitude );

        if( abs( $longitude ) > 180 ) {
            $longitude = $default;
        }

        return $longitude;
    }
}