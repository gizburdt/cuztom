<?php

class Cuztom_Field_Post_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->args = array_merge(
					
			// Default
			array(
				'post_type'		=> 'post',
			),
			
			// Given
			$this->args
		
		);

		$this->posts 	= get_posts( $this->args );
	}
	
	function _output( $value )
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
	
	function _repeatable_output( $value )
	{
		$this->after = '[]';
		$output = '';

		if( is_array( $value ) )
		{
			foreach( $value as $item )
			{
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $item ) . '</li>';
			}
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $value ) . '</li>';
		}

		return $output;
	}
}