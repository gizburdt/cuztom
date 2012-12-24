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
		
		$this->options['class'] .= ' cuztom-input';
		$this->options['name'] 	= 'cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' );
		$this->options['echo']	= 0;
	}

	function _output( $value )
	{
		$this->options['selected'] 	= ( ! empty( $value ) ? $value : $this->default_value );

		$output = ( $this->repeatable ? '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' : '' );
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
			
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
				$output .= wp_dropdown_categories( $this->options );
			$output .= ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}	
}