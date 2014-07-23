<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Gallery extends Cuztom_Field
{
    /**
     * Feature support
     */
    var $_supports_repeatable   = true;
    var $_supports_ajax         = true;
    var $_supports_bundle       = true;

    /**
     * Attributes
     */
    var $css_classes            = array( 'cuztom-gallery' );

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
        $output = '';

        $output .= '<div class="cuztom-gallery" data-name="cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . '">';

        $output .= '<a href="javascript:void(null)" class="button-secondary button button-small cuztom-button js-cz-edit-gallery">' . __( 'Edit Gallery', 'cuztom' ) . '</a>';
        $output .= '<div class="dropzone"></div>';
        $output .= '<div class="cuztom-gallery-preview"><ul class="list"></li></div>';

        if( ! empty( $value ) ) {
            if( isset( $value['link'] ) ) {
                $output .= '<input type="hidden" name="cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . '[link]" value="' . $value['link'] . '"';
            }

            if( isset( $value['columns'] ) ) {
                $output .= '<input type="hidden" name="cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . '[columns]" value="' . $value['columns'] . '"';
            }

            if( isset( $value['random'] ) ) {
                $output .= '<input type="hidden" name="cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . '[random]" value="' . $value['random'] . '"';
            }

            if( isset( $value['images'] ) ) {
                foreach( $value['images'] as $image ) {
                    $output .= '<input type="hidden" name="cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . '[images][]" value="' . $image . '" />';
                }
            }
        }

        $output .= '</div>';

        $output .= $this->output_explanation();

        return $output;
    }
}
