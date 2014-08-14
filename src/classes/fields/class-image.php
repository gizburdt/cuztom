<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Image extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_repeatable	= true;
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes			= array( 'cuztom-hidden', 'cuztom-input' );
	var $data_attributes 		= array( 'media-type' => 'image' );

	/**
	 * Output method
	 *
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.4
	 *
	 */
	function _output( $value = null )
	{
		$output = '';
		$image 	= '';

		if( ! empty( $value ) ) {
			$url 	= wp_get_attachment_image_src( $value, ( ! empty( $this->args["preview_size"] ) ? $this->args["preview_size"] : apply_filters( 'cuztom_preview_size', 'medium' ) ) );
			$url 	= $url[0];
			$image  = '<img src="' . $url . '" />';
		}

		$output .= '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= '<input ' . $this->output_id() . ' ' . $this->output_data_attributes() . ' type="button" class="button button-small js-cztm-upload" value="' . __( 'Select image', 'cuztom' ) . '" />';
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cztm-remove-media cuztom-remove-media" title="%s" tabindex="-1"></a>', __( 'Remove current file', 'cuztom' ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $image . '</span>';
		$output .= $this->output_explanation();

		return $output;
	}

	/**
	 * Outputs the fields column content
	 *
	 * @author  Gijs Jorissen
	 * @since  	3.0
	 *
	 */
	function output_column_content( $post_id )
	{
		$meta = get_post_meta( $post_id, $this->id, true );
		echo wp_get_attachment_image( $meta, array( 100, 100 ) );
	}
}
