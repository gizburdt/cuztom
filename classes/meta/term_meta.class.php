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
		
		// Build the meta box and fields
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
		$value = get_cuztom_term_meta( $term->term_id, $term->taxonomy );

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
			$data 		= array();
			$values 	= isset( $_POST['cuztom'] ) ? $_POST['cuztom'] : '';
			$taxonomy 	= $_POST['taxonomy'];

			foreach( $this->fields as $id_name => $field )
			{				
				$data[$id_name] = $field->save_value( $values[$field->id] );			
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
		foreach( $this->fields as $id_name => $field )
			if( $field->show_admin_column ) $columns[$id_name] = $field->label;

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
			
			foreach( $this->fields as $id_name => $field )
			{
				if( $column == $id_name )
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
