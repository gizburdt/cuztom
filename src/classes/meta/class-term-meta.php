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
	var $data;
	var $fields;
	var $locations;

	/**
	 * Construct the term meta
	 * 
	 * @param 	string|array 	$taxonomy
	 * @param 	array  			$data
	 *
	 * @author 	Gijs Jorissen
 	 * @since 	2.5
	 */
	function __construct( $taxonomy, $data = array(), $locations = array( 'add_form', 'edit_form' ) )
	{
		$this->taxonomies 	= (array) $taxonomy;
		$this->locations 	= (array) $locations;
		
		// Build fields
		if( ! Cuztom::is_wp_callback( $data ) )
		{
			$this->data = $this->build( $data );

			foreach( $this->taxonomies as $taxonomy )
			{
				if( in_array( 'add_form', $this->locations ) )
				{
					add_action( $taxonomy . '_add_form_fields', array( &$this, 'add_form_fields' ) );
					add_action( 'created_' . $taxonomy, array( &$this, 'save_term' ) );
				}

				if( in_array( 'edit_form', $this->locations ) )
				{
					add_action( $taxonomy . '_edit_form_fields', array( &$this, 'edit_form_fields' ) );
					add_action( 'edited_' . $taxonomy, array( &$this, 'save_term' ) );
				}

				add_filter( 'manage_edit-' . $taxonomy . '_columns', array( &$this, 'add_column' ) );
				add_filter( 'manage_' . $taxonomy . '_custom_column', array( &$this, 'add_column_content' ), 10, 3 );
			}
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
		$term = null;

		parent::callback( $term, $this->data, array( 'taxonomy' => $taxonomy ) );
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
		echo '</table>';
		
		parent::callback( $term, $this->data, array( 'taxonomy' => $term->taxonomy ) );
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
			$data 		= array();
			$values 	= isset( $_POST['cuztom'] ) ? $_POST['cuztom'] : '';
			$taxonomy 	= $_POST['taxonomy'];

			foreach( $this->fields as $id => $field )
			{				
				$data[$id] = $field->save_value( $values[$field->id] );			
			}

			update_option( 'term_meta_' . $taxonomy . '_' . $term_id, $data );
		}
	}

	/**
	 * Used to add a column head to the Taxonomy's List Table
	 *
	 * @param 	array 			$columns
	 * @return 	array
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.1
	 *
	 */
	function add_column( $columns )
	{
		foreach( $this->fields as $id => $field )
			if( $field->show_admin_column ) $columns[$id] = $field->label;

		return $columns;
	}

	/**
	 * Used to add the column content to the column head
	 *
	 * @param 	string 			$row
	 * @param 	integer 		$column
	 * @param 	integer 		$term_id
	 * @return 	mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.1
	 *
	 */
	function add_column_content( $row, $column, $term_id )
	{
		$screen 	= get_current_screen();

		if( $screen )
		{
			$taxonomy 	= $screen->taxonomy;

			$meta = get_cuztom_term_meta( $term_id, $taxonomy, $column );
			
			foreach( $this->fields as $id => $field )
			{
				if( $column == $id )
				{
					if( $field->repeatable && $field->_supports_repeatable )
					{
						echo implode( $meta, ', ' );
					}
					else
					{
						if( $field instanceof Cuztom_Field_Image )
							echo wp_get_attachment_image( $meta, array( 100, 100 ) );
						else
							echo $meta;
					}

					break;
				}
			}
		}
	}
}
