<?php

class Cuztom_Field_Post_Checkboxes extends Cuztom_Field
{
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->options = array_merge(
					
			// Default
			array(
				'post_type'		=> 'post',
			),
			
			// Given
			$this->options
		
		);
		
		$this->posts = get_posts( $this->options );
	}
	
	function _output( $value )
	{		
		$output = '<div class="cuztom_post_wrap cuztom_checked_wrap cuztom_padding_wrap">';
			if( is_array( $this->posts ) )
			{
				foreach( $this->posts as $post )
				{
					$output .= '<input type="checkbox" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . Cuztom::uglify( $post->post_title ) . '" value="' . $post->ID . '" ' . ( ! empty( $value ) ? ( in_array( $post->ID, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $this->default_value ) && in_array( $post->ID, $this->default_value ) ) ? 'checked="checked"' : checked( $this->default_value, $post->ID, false ) ) . ' class="cuztom_input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $post->post_title ) . '">' . $post->post_title . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		return $output;
	}	
}