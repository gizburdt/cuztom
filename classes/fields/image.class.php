<?php

class Cuztom_Field_Image extends Cuztom_Field
{
	var $_supports_ajax			= true;
	
	function _output( $value )
	{
		$output = '';

		if( ! empty( $value ) )
		{
			$url = wp_get_attachment_image_src( $value, apply_filters( 'cuztom_preview_size', 'medium' ) );
			$url = $url[0];
			$image  = '<img src="' . $url . '" />';
		}
		else 
		{
			$image = '';
		}
	
		$output .= '<input type="hidden" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom-hidden cuztom-input" value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= sprintf( '<input id="upload-image-button" type="button" class="button js-cuztom-upload" data-cuztom-media-type="image" value="%s" />', __( 'Select image', 'cuztom' ) );
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom-remove-media">%s</a>', __( 'Remove current image', 'cuztom' ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $image . '</span>';

		return $output;
	}
}