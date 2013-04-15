<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Post_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->args = array_merge(
			array(
				'post_type'			=> 'post',
				'posts_per_page'	=> -1
			),
			$this->args
		);

		$this->posts 	= get_posts( $this->args );
	}
	
	function _output( $value, $object )
	{
		$output = '<select name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" class="cuztom-input">';
			if( isset( $this->args['option_none'] ) && $this->args['option_none'] )
				$output .= '<option value="0" ' . ( empty( $value ) ? 'selected="selected"' : '' ) . '>' . __( 'None', 'cuztom' ) . '</option>';

			if( is_array( $this->posts ) )
			{
				foreach( $posts = $this->posts as $post )
				{
					$output .= '<option value="' . $post->ID . '" ' . ( ! empty( $value ) ? selected( $post->ID, $value, false ) : selected( $this->default_value, $post->ID, false ) ) . '>' . $post->post_title . '</option>';
				}
			}
		$output .= '</select>';

		return $output;
	}
}