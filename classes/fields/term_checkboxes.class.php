<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Term_Checkboxes extends Cuztom_Field
{
	var $_supports_bundle		= true;
	
	var $css_classes 			= array( 'cuztom-input' );
	var $terms;

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->args = array_merge(
			array(
				'taxonomy'		=> 'category',
			),
			$this->args
		);

		$this->default_value = (array) $this->default_value;

		add_action( 'init', array( &$this, 'get_taxonomy_terms' ) );

		$this->after .= '[]';
	}
	
	function _output( $value )
	{
		$output = '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->terms ) )
			{
				foreach( $this->terms as $term )
				{
					$output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_' . Cuztom::uglify( $term->name ) ) . ' ' . $this->output_css_class() . ' value="' . $term->term_id . '" ' . ( is_array( $value ) ? ( in_array( $term->term_id, $value ) ? 'checked="checked"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $term->term_id, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' /> ';
					$output .= '<label for="' . $this->id . $this->after_id . '_' . Cuztom::uglify( $term->name ) . '">' . $term->name . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}

	function save_value( $value )
	{
		return empty( $value ) ? '-1' : $value;
	}
	
	/**
	 * Gets taxonomy terms for use in the output
	 * 
	 * @author 	Abhinav Sood
	 * @since 	1.6.1
	 * 
	 */
	function get_taxonomy_terms()
    {
        $this->terms = get_terms( $this->args['taxonomy'], $this->options );
    }
}
