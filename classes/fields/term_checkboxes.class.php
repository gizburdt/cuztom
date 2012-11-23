<?php

class Cuztom_Field_Term_Checkboxes extends Cuztom_Field
{
	var $terms;

	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->options = array_merge(
					
			// Default
			array(
				'taxonomy'		=> 'category',
			),
			
			// Given
			$this->options
			
		);

		add_action( 'init', array( &$this, 'get_taxonomy_terms' ) );
	}
	
	function _output( $value )
	{
		$output = '<div class="cuztom_taxonomy_wrap cuztom_checked_wrap cuztom_padding_wrap">';
			if( is_array( $this->terms ) )
			{
				foreach( $this->terms as $term )
				{
					$output .= '<input type="checkbox" name="cuztom[' . $this->id_name . '][]" id="' . $this->id_name . '_' . Cuztom::uglify( $term->name ) . '" value="' . $term->term_id . '" ' . ( ! empty( $value ) ? ( in_array( $term->term_id, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $this->default_value ) && in_array( $term->term_id, $this->default_value ) ) ? 'checked="checked"' : ( $value == -1 ) ? '' : checked( $this->default_value, $term->term_id, false ) ) . ' class="cuztom_input" /> ';
					$output .= '<label for="' . $this->id_name . '_' . Cuztom::uglify( $term->name ) . '">' . $term->name . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		return $output;
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
        $this->terms = get_terms( $this->options['taxonomy'], $this->options );
    }
}