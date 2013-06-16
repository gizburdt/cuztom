<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the meta boxes
 *
 * @author 	Gijs Jorissen
 * @since 	2.5
 *
 */
class Cuztom_Term_Meta extends Cuztom_Meta
{
	var $taxonomies;

	/**
	 * Construct the term meta
	 * 
	 * @param 	string 		$taxonomy
	 * @param 	array  		$data
	 *
	 * @author 	Gijs Jorissen
 	 * @since 	2.5
	 */
	function __construct( $taxonomy, $data = array() )
	{
		$this->taxonomies 	= (array) $taxonomy;
		
		// Build the meta box and fields
		$this->build( $data );

		foreach( $this->taxonomies as $taxonomy )
		{
			add_action( $taxonomy . '_add_form_fields', array( &$this, 'add_form_fields' ) );
			add_action( $taxonomy . '_edit_form_fields', array( &$this, 'edit_form_fields' ) );

			add_action( 'created_' . $taxonomy, array( &$this, 'save_term' ) );
			add_action( 'edited_' . $taxonomy, array( &$this, 'save_term' ) );  
		}
	}

	/**
	 * Add fields to the add term form
	 * 
	 * @param 	string 		$taxonomy
	 *
	 * @author 	Gijs Jorissen
 	 * @since 	2.5
	 */
	function add_form_fields( $taxonomy )
	{
		echo '<input type="hidden" name="cuztom[__activate]" />';

		/* Loop through $data */
		foreach( $this->data as $id_name => $field )
		{
			$value = '';

			if( ! $field instanceof Cuztom_Field_Hidden )
			{
				echo '<div class="form-field">';
					echo '<label for="' . $id_name . '" class="cuztom_label">' . $field->label . '</label>';
					echo $field->output( $value );

					if( ! empty( $field->description ) ) echo '<p class="cuztom-description">' . $field->description . '</p>';
				echo '</div>';
			}
			else
			{
				echo $field->output( $value );
			}
		}
	}

	/**
	 * Add fields to the edit term form
	 * 
	 * @param 	string 		$term
	 *
	 * @author 	Gijs Jorissen
 	 * @since 	2.5
	 */
	function edit_form_fields( $term )
	{
		$value = get_option( 'term_meta_' . $term->term_id );

		echo '<input type="hidden" name="cuztom[__activate]" />';

		/* Loop through $data */
		foreach( $this->data as $id_name => $field )
		{
			$value[$id_name] = isset( $value[$id_name] ) ? $value[$id_name] : '';

			if( ! $field instanceof Cuztom_Field_Hidden )
			{
				echo '<tr class="cuztom form-field">';
					echo '<th scope="row" valign="top">';
						echo '<label for="' . $id_name . '" class="cuztom_label">' . $field->label . '</label>';
					echo '</th>';
					echo '<td class="cuztom-td">';
						echo $field->output( $value[$id_name] );
						if( ! empty( $field->description ) ) echo '<p class="description cuztom-description">' . $field->description . '</p>';
					echo '</td>';
				echo '</tr>';
			}
			else
			{
				echo $field->output( $value );
			}
		}
	}

	/**
	 * Save the term
	 * 
	 * @param 	int 		$term_id
	 *
	 * @author 	Gijs Jorissen
 	 * @since 	2.5
	 */
	function save_term( $term_id )
	{
		// Loop through each meta box
		if( ! empty( $this->data ) && isset( $_POST['cuztom'] ) )
		{
			$data = array();

			foreach( $this->fields as $id_name => $field )
			{
				$value = isset( $_POST['cuztom'][$id_name] ) ? $_POST['cuztom'][$id_name] : '';
				// $data[$id_name] = $field->save( $term_id, $value, 'term' );
				
				$data[$id_name] = $field->save( $term_id, $value, 'term' );				
			}

			update_option( 'term_meta_' . $term_id, $data );
		}
	}
}
