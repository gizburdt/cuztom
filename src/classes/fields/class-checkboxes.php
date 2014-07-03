<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Checkboxes extends Cuztom_Field
{
	/**
	 * Feature support
	 */
	var $_supports_bundle			= true;
	
	/**
	 * Attributes
	 */
	var $css_classes				= array( 'cuztom-input' );

	/**
	 * Constructs Cuztom_Field_Checkboxes
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3.3
	 *
	 */
	function __construct( $field )
	{
		parent::__construct( $field );

		$this->default_value = (array) $this->default_value;
		$this->after 		.= '[]';
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
		$output = '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . ( is_array( $this->value ) ? ( in_array( $slug, $this->value ) ? 'checked="checked"' : '' ) : ( ( $this->value == '-1' ) ? '' : in_array( $slug, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' /> ';
					$output .= '<label ' . $this->output_for_attribute( $this->id . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . '>' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}

	/**
	 * Parse value
	 * 
	 * @param 	string 		$value
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8
	 * 
	 */
	function save_value( $value )
	{
		return empty( $value ) ? '-1' : $value;
	}
}