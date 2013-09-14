<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Image extends Cuztom_Field
{
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes			= array( 'cuztom-hidden', 'cuztom-input' );
	
	function _output( $value )
	{
		$output = '';

		if( ! empty( $value ) )
		{
			$url = wp_get_attachment_image_src( $value, ! empty( $this->args["preview_size"] ) ? $this->args["preview_size"] : apply_filters( 'cuztom_preview_size', 'medium' ) );
			$url = $url[0];
			$image  = '<img src="' . $url . '" />';
		}
		else 
		{
			$image = '';
		}
	
		$output .= '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= sprintf( '<input id="upload-image-button" type="button" class="button js-cuztom-upload" data-cuztom-media-type="image"' . ( ! empty($this->args["preview_size"] ) ? ' data-cuztom-media-preview-size="' . ( is_array($this->args["preview_size"] ) ? esc_attr( json_encode($this->args["preview_size"] ) ) : $this->args["preview_size"] ) . '"' : '') . ' value="%s" />', __( 'Select image', 'cuztom' ) );
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom-remove-media">%s</a>', __( 'Remove current image', 'cuztom' ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $image . '</span>';

		$output .= $this->output_explanation();

		return $output;
	}
}
