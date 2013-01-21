<?php

class Cuztom_Field_Term_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	
	var $dropdown;
	var $value;

	function __construct( $field, $meta_box, $post = null )
	{
		parent::__construct( $field, $meta_box );

		$this->args = array_merge(

			// Default
			array(
				'taxonomy'		=> 'category',
				'class'			=> '',
				'hide_empty'	=> 0
			),
			
			// Given
			$this->args

		);
		
		$this->args['class'] 	.= ' cuztom-input';
		$this->args['name'] 	= 'cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' );
		$this->args['id']		= $this->id_name;
		$this->args['echo']		= 0;
	}

	function _output( $value )
	{
		$this->args['selected'] = ( ! empty( $value ) ? $value : $this->default_value );
		$this->dropdown 		= wp_dropdown_categories( $this->args );

		$output = $this->dropdown;

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
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
					$output .= $this->_output( $item );
				$output .= ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
			}
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
				$output .= $this->_output( $value );
			$output .= ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}
}