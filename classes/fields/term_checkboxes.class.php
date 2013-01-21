<?php

class Cuztom_Field_Term_Checkboxes extends Cuztom_Field
{
	var $terms;

	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->args = array_merge(
					
			// Default
			array(
				'taxonomy'		=> 'category',
			),
			
			// Given
			$this->args
			
		);

		$this->default_value = (array) $this->default_value;

		add_action( 'init', array( &$this, 'get_taxonomy_terms' ) );
	}
	
	function _output( $value )
	{
		$output = '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->terms ) )
			{
				foreach( $this->terms as $term )
				{
					$output .= '<input type="checkbox" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . Cuztom::uglify( $term->name ) . '" value="' . $term->term_id . '" ' . ( is_array( $value ) ? ( in_array( $term->term_id, $value ) ? 'checked="checked"' : '' ) : ( ( $value == '-1' ) ? '' : in_array( $term->term_id, $this->default_value ) ? 'checked="checked"' : '' ) ) . ' class="cuztom-input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $term->name ) . '">' . $term->name . '</label>';
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