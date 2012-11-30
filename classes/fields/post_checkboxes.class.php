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
					$output .= '<input type="checkbox" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . Cuztom::uglify( $post->post_title ) . '" value="' . $post->ID . '" ' . ( is_array( $value ) ? ( in_array( $post->ID, $value ) ? 'checked="checked"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $post->ID, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' class="cuztom_input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $post->post_title ) . '">' . $post->post_title . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		return $output;
	}

	function save( $post_id, $value )
	{
		$value = empty( $value ) ? '-1' : $value;

		parent::save( $post_id, $value );
	}	
}