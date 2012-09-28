<?php

class Cuztom_Field_Image extends Cuztom_Field
{
	function _output( $value )
	{				
		$image = ( ! empty( $value ) ) ? '<img src="' . $value . '" />' : '';
	
		$output = '<div class="cuztom_button_wrap">';
			$output .= '<input type="hidden" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom_hidden" value="' . ( ! empty( $value ) ? $value : '' ) . '" class="cuztom_input" />';
			$output .= '<input id="upload_image_button" type="button" class="button cuztom_button cuztom_upload" value="' . __( 'Select image', CUZTOM_TEXTDOMAIN ) . '" class="cuztom_upload" />';
			$output .= ( ! empty( $value ) ? '<a href="#" class="cuztom_remove_image">' . __( 'Remove current image', CUZTOM_TEXTDOMAIN ) . '</a>' : '' );
		$output .= '</div>';
		$output .= '<span class="cuztom_preview">' . $image . '</span>';

		return $output;
	}
}