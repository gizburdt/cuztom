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
			$url = wp_get_attachment_image_src( $value, ( ! empty( $this->args["preview_size"] ) ? $this->args["preview_size"] : apply_filters( 'cuztom_preview_size', 'medium' ) ) );
			$url = $url[0];
			$image  = '<img src="' . $url . '" />';
		}
		else 
		{
			$image = '';
		}
	
		$output .= '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= sprintf( '<input id="upload-image-button" type="button" class="button js-cuztom-upload" value="%s" />', __( 'Select image', 'cuztom' ) );
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom-remove-media" title="%s"></a>', __( 'Remove current file', 'cuztom' ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $image . '</span>';

		$output .= $this->output_explanation();

		return $output;
	}
}
