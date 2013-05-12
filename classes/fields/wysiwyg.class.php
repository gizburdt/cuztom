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
				'textarea_name' => 'cuztom[' . $this->id_name . ']',
				'editor_class'	=> ''
			),
			$this->args
		);
		
		$this->args['editor_class'] .= ' cuztom-input';
	}

	function _output( $value, $object )
	{	
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->id_name, $this->args ) . $this->output_explanation();
	}

	function save( $id, $value, $context )
	{
		$value = wpautop( $value );

		parent::save( $id, $value, $context );
	}
}