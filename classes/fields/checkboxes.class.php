<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Checkboxes extends Cuztom_Field
{
	var $css_classes				= array( 'cuztom-input' );

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->default_value = (array) $this->default_value;
	}

	function _output( $value, $object )
	{
		$output = '<div class="cuztom-padding-wrap cuztom-checkboxes-wrap">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$output .= '<input type="checkbox" ' . $this->output_name( 'cuztom[' . $this->id_name . '][]' ) . ' ' . $this->output_id( $this->id_name . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . ( is_array( $value ) ? ( in_array( $slug, $value ) ? 'checked="checked"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $slug, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' /> ';
					$output .= '<label ' . $this->output_for_attribute( $this->id_name . $this->after_id . '_' . Cuztom::uglify( $slug ) ) . '>' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}

	function save( $id, $value, $meta_type )
	{
		$value = empty( $value ) ? '-1' : $value;

		parent::save( $id, $value, $meta_type );
	}
}