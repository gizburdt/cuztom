<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_File extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes 			= array( 'cuztom-hidden', 'cuztom-input' );
	var $data_attributes 		= array( 'media-type' => 'file' );

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

		if( ! empty( $value ) ) {
			$attachment = self::get_attachment_by_url( $value );
			$mime = '';

			if( is_object( $attachment ) ) {
				$mime = str_replace( '/', '_', $attachment->post_mime_type );
				$name = $attachment->post_title;
			}

			$file = '<span class="cuztom-mime mime-' . $mime . '"><a target="_blank" href="' . $value . '">' . $name . '</a></span>';
		} else {
			$file = '';
		}

		$output .= '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_css_class() . ' ' . $this->output_value( $value ) . ' ' . '" />';
		$output .= '<input ' . $this->output_id() . ' ' . $this->output_data_attributes() . ' type="button" class="button js-cz-upload" value="' . __( 'Select file', 'cuztom' ) . '" />';
		$output .= ( ! empty( $value ) ? sprintf( '<a href="#" class="js-cz-remove-media cuztom-remove-media">%s</a>', __( 'Remove current file', 'cuztom' ) ) : '' );

		$output .= '<span class="cuztom-preview">' . $file . '</span>';
		$output .= $this->output_explanation();

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

		$attachment = $wpdb->get_row( $wpdb->prepare( "SELECT ID,post_title,post_mime_type FROM " . $wpdb->prefix . "posts" . " WHERE guid=%s;", $url ) );

		return $attachment;
	}
}