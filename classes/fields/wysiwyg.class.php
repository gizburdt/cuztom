<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Wysiwyg extends Cuztom_Field
{
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

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
		$this->args['textarea_name'] = 'cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after;
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->id_field, $this->args );
	}

	function save( $post_id, $value, $context )
	{
		$value = wpautop( $value );

		parent::save( $post_id, $value, $context );
	}
}