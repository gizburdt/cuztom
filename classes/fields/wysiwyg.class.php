<?php

class Cuztom_Field_Wysiwyg extends Cuztom_Field
{
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->options = array_merge( 
					
			// Default
			array(
				'textarea_name' => 'cuztom[' . $this->id_name . ']',
				'media_buttons' => false,
				'editor_class'	=> ''
			),
			
			// Given
			$this->options
		
		);
		
		$this->options['editor_class'] .= ' cuztom_input';
	}

	function _output( $value )
	{	
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->id_name, $this->options );
	}
}