<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Wysiwyg extends Cuztom_Field
{
	var $_supports_ajax			= true;
	
	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->args = array_merge( 
			array(
				'textarea_name' => 'cuztom[' . $this->id . ']',
				'editor_class'	=> ''
			),
			$this->args
		);
		
		$this->args['editor_class'] .= ' cuztom-input';
	}

	function _output( $value )
	{	
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->id, $this->args ) . $this->output_explanation();
	}

	function save( $id, $value )
	{
		$value = wpautop( $value );

		return parent::save( $id, $value );
	}
}