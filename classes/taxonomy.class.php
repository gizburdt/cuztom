<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates custom taxonomies
 *
 * @author 	Gijs Jorissen
 * @since 	0.2
 *
 */
class Cuztom_Taxonomy
{
	var $name;
	var $title;
	var $plural;
	var $labels;
	var $args;
	var $post_type;
	
	/**
	 * Constructs the class with important vars and method calls
	 * If the taxonomy exists, it will be attached to the post type
	 *
	 * @param 	string 			$name
	 * @param 	string 			$post_type
	 * @param 	array 			$args
	 * @param 	array 			$labels
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function __construct( $name, $post_type = null, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			$this->post_type = (array) $post_type;

			if( is_array( $name ) )
			{
				$this->name		= Cuztom::uglify( $name[0] );
				$this->title	= Cuztom::beautify( $name[0] );
				$this->plural 	= Cuztom::beautify( $name[1] );
			}
			else
			{
				$this->name		= Cuztom::uglify( $name );
				$this->title	= Cuztom::beautify( $name );
				$this->plural 	= Cuztom::pluralize( Cuztom::beautify( $name ) );
			}

			$this->labels	= $labels;
			$this->args		= $args;
            
            if( ! taxonomy_exists( $this->name ) )
			{
				if ( $is_reserved_term = Cuztom::is_reserved_term( $this->name ) )
	            	new Cuztom_Notice( $is_reserved_term->get_error_message(), 'error' );
				else
					$this->register_taxonomy();
			}
			else
			{
				$this->register_taxonomy_for_object_type();
			}

			if( isset( $args['show_admin_column'] ) && $args['show_admin_column'] )
			{
				foreach($this->post_type as $post_type) :
					if( get_bloginfo( 'version' ) < '3.5' ) {
						add_filter( 'manage_' . $post_type . '_posts_columns', array( &$this, 'add_column' ) );
						add_action( 'manage_' . $post_type . '_posts_custom_column', array( &$this, 'add_column_content' ), 10, 2 );
					}

					if( isset( $args['admin_column_sortable'] ) && $args['admin_column_sortable'] ) {
						add_action( 'manage_edit-' . $post_type . '_sortable_columns', array( &$this, 'add_sortable_column' ), 10, 2 );
					}
				endforeach;

				if( isset( $args['admin_column_filter'] ) && $args['admin_column_filter'] )
				{
					add_action( 'restrict_manage_posts', array( &$this, '_post_filter' ) );
					add_filter( 'parse_query', array( &$this, '_post_filter_query') );
				}
			}
		}
	}
	
	/**
	 * Registers the custom taxonomy with the given arguments
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function register_taxonomy()
	{
		// Default labels, overwrite them with the given labels.
		$labels = array_merge(
			array(
				'name' 					=> sprintf( _x( '%s', 'taxonomy general name', 'cuztom' ), $this->plural ),
				'singular_name' 		=> sprintf( _x( '%s', 'taxonomy singular name', 'cuztom' ), $this->title ),
			    'search_items' 			=> sprintf( __( 'Search %s', 'cuztom' ), $this->plural ),
			    'all_items' 			=> sprintf( __( 'All %s', 'cuztom' ), $this->plural ),
			    'parent_item' 			=> sprintf( __( 'Parent %s', 'cuztom' ), $this->title ),
			    'parent_item_colon' 	=> sprintf( __( 'Parent %s:', 'cuztom' ), $this->title ),
			    'edit_item' 			=> sprintf( __( 'Edit %s', 'cuztom' ), $this->title ), 
			    'update_item' 			=> sprintf( __( 'Update %s', 'cuztom' ), $this->title ),
			    'add_new_item' 			=> sprintf( __( 'Add New %s', 'cuztom' ), $this->title ),
			    'new_item_name' 		=> sprintf( __( 'New %s Name', 'cuztom' ), $this->title ),
			    'menu_name' 			=> sprintf( __( '%s', 'cuztom' ), $this->plural )
			),
			$this->labels
		);

		// Default arguments, overwitten with the given arguments
		$args = array_merge(
			array(
				'label'					=> sprintf( __( '%s', 'cuztom' ), $this->plural ),
				'labels'				=> $labels,
				'hierarchical' 			=> true,
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
				'show_admin_column'		=> false
			),
			$this->args
		);
		
		register_taxonomy( $this->name, $this->post_type, $args );
	}
	
	/**
	 * Used to attach the existing taxonomy to the post type
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function register_taxonomy_for_object_type()
	{
		register_taxonomy_for_object_type( $this->name, $this->post_type );
	}

	/**
	 * Add term meta to this taxonomy
	 *
	 * @param 	array 			$data
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.5
	 *
	 */
	function add_term_meta( $data = array(), $locations = array( 'add_form', 'edit_form' ) )
	{
		$meta = new Cuztom_Term_Meta( $this->name, $data, $locations );

		return $this;
	}

	/**
	 * Used to add a column head to the Post Type's List Table
	 *
	 * @param 	array 			$columns
	 * @return 	array
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.6
	 *
	 */
	function add_column( $columns )
	{
		unset( $columns['date'] );

		$columns[$this->name] = $this->title;
		$columns['date'] = __( 'Date', 'cuztom' );
		
		return $columns;
	}
	
	/**
	 * Used to add the column content to the column head
	 *
	 * @param 	string 			$column
	 * @param 	integer 		$post_id
	 * @return 	mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.6
	 *
	 */
	function add_column_content( $column, $post_id )
	{
		if ( $column === $this->name ) 
		{
			$terms = wp_get_post_terms( $post_id, $this->name, array( 'fields' => 'names' ) );

			echo implode( $terms, ', ' );
		}
	}

	/**
	 * Used to make all columns sortable
	 * 
	 * @param 	array 			$columns
	 * @return  array
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6
	 * 
	 */
	function add_sortable_column( $columns )
	{
		$columns[( get_bloginfo( 'version' ) < '3.5' ) ? $this->name : 'taxonomy-' . $this->name] = $this->title;

		return $columns;
	}

	/**
	 * Adds a filter to the post table filters
	 * 
	 * @author 	Gijs Jorissen
	 * @since 	1.6
	 * 
	 */
	function _post_filter() 
	{
		global $typenow, $wp_query;

		if( in_array( $typenow, $this->post_type ) )
		{
			wp_dropdown_categories( array(
				'show_option_all'	=> sprintf( __( 'Show all %s', 'cuztom' ), $this->plural ),
				'taxonomy'       	=> $this->name,
				'name'            	=> $this->name,
				'orderby'         	=> 'name',
				'selected'        	=> isset( $wp_query->query[$this->name] ) ? $wp_query->query[$this->name] : '',
				'hierarchical'    	=> true,
				'show_count'      	=> true,
				'hide_empty'      	=> true,
			) );
		}
	}

	/**
	 * Applies the selected filter to the query
	 * 
	 * @param 	object 			$query
	 *
	 * @author  Gijs Jorissen
	 * @since  	1.6
	 * 
	 */
	function _post_filter_query( $query ) 
	{
    	global $pagenow;
    	$vars = &$query->query_vars;

		if( $pagenow == 'edit.php' && isset( $vars[$this->name] ) && is_numeric( $vars[$this->name] ) && $vars[$this->name] ) 
    	{
    		$term = get_term_by( 'id', $vars[$this->name], $this->name );
        	$vars[$this->name] = $term->slug;
    	}

    	return $vars;
	}
}