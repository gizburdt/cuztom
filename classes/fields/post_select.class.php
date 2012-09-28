<?php

class Cuztom_Field_Post_Select extends Cuztom_Field
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

		$this->posts 	= get_posts( $this->options );
	}
	
	function _output( $value )
	{
		$output = ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<select name="cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' ) . '" id="' . $this->id_name . '">';
			if( is_array( $this->posts ) )
			{
				foreach( $posts = $this->posts as $post )
				{
					$output .= '<option value="' . $post->ID . '" ' . ( ! empty( $value ) ? selected( $post->ID, $value, false ) : selected( $this->default_value, $post->ID, false ) ) . '>' . $post->post_title . '</option>';
				}
			}
		$output .= '</select>' . ( $this->repeatable ? '</li>' : '' );

		return $output;
	}
	
	function _repeatable_output( $value )
	{
		$output = '';

		foreach( $value as $item )
		{
			$output .= '<li class="cuztom_field"><div class="handle_repeatable"></div><select name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '" class="cuztom_input">';
				if( is_array( $this->posts ) )
				{
					foreach( $this->posts as $post )
					{
						$output .= '<option value="' . $post->ID . '" ' . ( ! empty( $item ) ? selected( $post->ID, $item, false ) : selected( $this->default_value, $post->ID, false ) ) . '>' . $post->post_title . '</option>';
					}
				}
			$output .= '</select>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';;
		}

		return $output;
	}
}