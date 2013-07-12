<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Term_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	
	var $dropdown;
	var $value;

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->args = array_merge(
			array(
				'taxonomy'		=> 'category',
				'class'			=> '',
				'hide_empty'	=> 0
			),
			$this->args
		);
		
		$this->args['class'] 	.= ' cuztom-input';
		$this->args['name'] 	= 'cuztom[' . $this->id . ']' . ( $this->repeatable ? '[]' : '' );
		$this->args['id']		= $this->id . $this->after_id;
		$this->args['echo']		= 0;
	}

	function _output( $value )
	{
		$this->args['selected'] = ( ! empty( $value ) ? $value : $this->default_value );
		$this->dropdown 		= wp_dropdown_categories( $this->args );

		$output = $this->dropdown;

		$output .= $this->output_explanation();

		return $output;
	}
}