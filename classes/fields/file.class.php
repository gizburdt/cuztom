<?php

class Cuztom_Field_File extends Cuztom_Field
{
	function _output( $value )
	{
		if( ! empty( $value ) )
		{
			$attachment = self::get_attachment_by_url( $value );
			$mime = str_replace( '/', '_', $attachment->post_mime_type );
			$name = $attachment->post_title;

			$file = '<span class="cuztom_mime mime_' . $mime . '"><a target="_blank" href="' . $value . '">' . $name . '</a></span>';
		}
		else 
		{
			$file = '';
		}
	
		$output = '<div class="cuztom_button_wrap">';
			$output .= '<input type="hidden" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom_hidden" value="' . ( ! empty( $value ) ? $value : '' ) . '" class="cuztom_input" />';
			$output .= sprintf( '<input id="upload_file_button" type="button" class="button cuztom_button cuztom_upload cuztom_file" value="%s" class="cuztom_upload" />', __( 'Select file', CUZTOM_TEXTDOMAIN ) );
			$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="cuztom_remove_file">%s</a>', __( 'Remove current file', CUZTOM_TEXTDOMAIN ) ) : '' );
		$output .= '</div>';
		$output .= '<span class="cuztom_preview">' . $file . '</span>';

		return $output;
	}


	/**
	 * Get attachment by given url
	 * 
	 * @param  string 			$url
	 * @return integer
	 */
	function get_attachment_by_url( $url ) 
	{
		global $wpdb;
		
		$attachment = $wpdb->get_row( $wpdb->prepare( "SELECT ID,post_title,post_mime_type FROM " . $wpdb->prefix . "posts" . " WHERE guid='" . $url . "';" ) );

		return $attachment;
	}
}