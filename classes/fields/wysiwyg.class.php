<?php

class Cuztom_Field_Wysiwyg extends Cuztom_Field
{
	var $_supports_ajax			= true;
	
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->args = array_merge( 
					
			// Default
			array(
				'textarea_name' => 'cuztom[' . $this->id_name . ']',
				'media_buttons' => false,
				'editor_class'	=> ''
			),
			
			// Given
			$this->args
		
		);
		
		$this->args['editor_class'] .= ' cuztom-input';
	}

	function _output( $value )
	{	
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->id_name, $this->args );
	}

	function save( $post_id, $value, $context )
	{
		$value = wpautop( $value );

		parent::save( $post_id, $value, $context );
	}
}