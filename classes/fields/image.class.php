<?php

class Cuztom_Field_Image extends Cuztom_Field
{
	function _output( $value )
	{
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
	
		$output = '<div class="cuztom_button_wrap">';
			$output .= '<input type="hidden" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom-hidden cuztom-input" value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
			$output .= sprintf( '<input id="upload_image_button" type="button" class="button cuztom_button cuztom_upload js-cuztom-upload" value="%s" />', __( 'Select image', CUZTOM_TEXTDOMAIN ) );
			$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom_remove_image">%s</a>', __( 'Remove current image', CUZTOM_TEXTDOMAIN ) ) : '' );
		$output .= '</div>';
		$output .= '<span class="cuztom-preview">' . $image . '</span>';

		return $output;
	}
}