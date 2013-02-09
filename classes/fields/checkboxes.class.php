<?php

class Cuztom_Field_Checkboxes extends Cuztom_Field
{
	function __construct( $field, $context )
	{
		parent::__construct( $field, $context );

		$this->default_value = (array) $this->default_value;
	}

	function _output( $value )
	{
		$output = '<div class="cuztom-padding-wrap cuztom-checkboxes-wrap">';
			if( is_array( $this->options ) )
			{
				foreach( $this->options as $slug => $name )
				{
					$slug = Cuztom::uglify( $slug );

					$output .= '<input type="checkbox" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . $slug . '" value="' . $slug . '" ' . ( is_array( $value ) ? ( in_array( $slug, $value ) ? 'checked="checked"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $slug, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' class="cuztom-input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		return $output;
	}

	function save( $post_id, $value, $context )
	{
		$value = empty( $value ) ? '-1' : $value;

		parent::save( $post_id, $value, $context );
	}
}