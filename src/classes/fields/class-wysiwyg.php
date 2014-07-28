<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Wysiwyg extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Constructs Cuztom_Field_Wysiwyg
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3.3
	 *
	 */
	function __construct( $field )
	{
		parent::__construct( $field );

		// Set necessary args
		$this->args['editor_class'] .= ' cuztom-input';
		$this->args['textarea_name'] = 'cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name;
	}

	/**
	 * Output method
	 *
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.4
	 *
	 */
	function _output( $value = null )
	{
		return wp_editor( ( ! empty( $value ) ? $value : $this->default_value ), $this->before_id . $this->id . $this->after_id, $this->args ) . $this->output_explanation();
	}
}