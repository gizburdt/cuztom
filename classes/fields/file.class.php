<?php

class Cuztom_Field_File extends Cuztom_Field
{
	function _output( $value )
	{
		$output = '';

		if( ! empty( $value ) )
		{
			$attachment = self::get_attachment_by_url( $value );
			$mime = str_replace( '/', '_', $attachment->post_mime_type );
			$name = $attachment->post_title;

			$file = '<span class="cuztom-mime mime-' . $mime . '"><a target="_blank" href="' . $value . '">' . $name . '</a></span>';
		}
		else 
		{
			$file = '';
		}
	
		$output .= '<input type="hidden" name="cuztom[' . $this->id_name . ']" id="' . $this->id_name . '" class="cuztom-hidden cuztom-input" value="' . ( ! empty( $value ) ? $value : '' ) . '" />';
		$output .= sprintf( '<input id="upload-file-button" type="button" class="button js-cuztom-upload" value="%s" />', __( 'Select file', CUZTOM_TEXTDOMAIN ) );
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cuztom-remove-media cuztom_remove_file">%s</a>', __( 'Remove current file', CUZTOM_TEXTDOMAIN ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $file . '</span>';

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