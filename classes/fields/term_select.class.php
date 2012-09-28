<?php

class Cuztom_Field_Term_Select extends Cuztom_Field
{
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->options = array_merge(

			// Default
			array(
				'taxonomy'		=> 'category',
				'class'			=> ''
			),
			
			// Given
			$this->options

		);
		
		$this->options['class'] 	.=  ' cuztom_input';
		$this->options['name'] 		= 'cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' );
		$this->options['echo']		= 0;
	}

	function _output( $value )
	{
		$this->options['selected'] 	= ( ! empty( $value ) ? $value : $this->default_value );

		$output = ( $this->repeatable ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' );
			$output .= wp_dropdown_categories( $this->options );
		$output .= ( $this->repeatable ? '</li>' : '' );

		return $output;
	}
	
	function _repeatable_output( $value )
	{
		$output = '';

		foreach( $value as $item )
		{
			$this->options['selected'] = ( ! empty( $item ) ? $item : $this->default_value );
			
			$output .= '<li class="cuztom_field"><div class="handle_repeatable"></div>';
				$output .= wp_dropdown_categories( $this->options );
			$output .= ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
		}

		return $output;
	}	
}