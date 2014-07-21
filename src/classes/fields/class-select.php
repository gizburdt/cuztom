<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Select extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_repeatable 	= true;
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	/**
	 * Attributes
	 */
	var $css_classes 			= array( 'cuztom-input cuztom-select' );
	var $data_attributes 		= array( 'default-value' => null );

	/**
	 * Constructs Cuztom_Field_Select
	 *
	 * @author 	Gijs Jorissen
	 * @since   0.3.3
	 *
	 */
	function __construct( $field )
	{
		parent::__construct( $field );

		$this->data_attributes['default-value'] = $this->default_value;
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
		$output = '<div class="cuztom-select-wrap"><select ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' ' . $this->output_data_attributes() . '>';
			if( isset( $this->args['show_option_none'] ) ) {
				$output .= '<option value="0" ' . ( empty( $this->value ) ? 'selected="selected"' : '' ) . '>' . $this->args['show_option_none'] . '</option>';
			}

			if( is_array( $this->options ) ) {
				foreach( $this->options as $slug => $name ) {
					$output .= '<option value="' . $slug . '" ' . ( ! empty( $this->value ) ? selected( $slug, $this->value, false ) : selected( $this->default_value, $slug, false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
				}
			}
		$output .= '</select></div>';
		$output .= $this->output_explanation();

		return $output;
	}
}