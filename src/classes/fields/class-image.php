<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Image extends Cuztom_Field
{
	var $_supports_repeatable	= true;
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes			= array( 'cuztom-hidden', 'cuztom-input' );
	
	function _output( $value = null )
	{
		$output = '';
		$image 	= '';

		if( ! empty( $this->value ) )
		{
			$url 	= wp_get_attachment_image_src( $this->value, ( ! empty( $this->args["preview_size"] ) ? $this->args["preview_size"] : apply_filters( 'cuztom_preview_size', 'medium' ) ) );
			$url 	= $url[0];
			$image  = '<img src="' . $url . '" />';
		}
	
		$output .= '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= sprintf( '<input id="upload-image-button" type="button" class="button button-small js-cuztom-upload" value="%s" />', __( 'Select image', 'cuztom' ) );
		$output .= ( ! empty( $this->value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom-remove-media" title="%s" tabindex="-1"></a>', __( 'Remove current file', 'cuztom' ) ) : '' );

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
