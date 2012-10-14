<?php

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
	var $post_type_name;
	
	
	/**
	 * Constructs the class with important vars and method calls
	 * If the taxonomy exists, it will be attached to the post type
	 *
	 * @param 	string 			$name
	 * @param 	string 			$post_type_name
	 * @param 	array 			$args
	 * @param 	array 			$labels
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function __construct( $name, $post_type_name = null, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			$this->post_type_name = $post_type_name;

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
				add_action( 'init', array( &$this, 'register_taxonomy' ) );
			}
			else
			{
				add_action( 'init', array( &$this, 'register_taxonomy_for_object_type' ) );
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

			// Default
			array(
				'name' 					=> _x( $this->plural, 'taxonomy general name', CUZTOM_TEXTDOMAIN ),
				'singular_name' 		=> _x( $this->title, 'taxonomy singular name', CUZTOM_TEXTDOMAIN ),
			    'search_items' 			=> __( 'Search ' . $this->plural, CUZTOM_TEXTDOMAIN ),
			    'all_items' 			=> __( 'All ' . $this->plural, CUZTOM_TEXTDOMAIN ),
			    'parent_item' 			=> __( 'Parent ' . $this->title, CUZTOM_TEXTDOMAIN ),
			    'parent_item_colon' 	=> __( 'Parent ' . $this->title . ':', CUZTOM_TEXTDOMAIN ),
			    'edit_item' 			=> __( 'Edit ' . $this->title, CUZTOM_TEXTDOMAIN ), 
			    'update_item' 			=> __( 'Update ' . $this->title, CUZTOM_TEXTDOMAIN ),
			    'add_new_item' 			=> __( 'Add New ' . $this->title, CUZTOM_TEXTDOMAIN ),
			    'new_item_name' 		=> __( 'New ' . $this->title . ' Name', CUZTOM_TEXTDOMAIN ),
			    'menu_name' 			=> __( $this->plural, CUZTOM_TEXTDOMAIN ),
			),

			// Given labels
			$this->labels

		);

		// Default arguments, overwitten with the given arguments
		$args = array_merge(

			// Default
			array(
				'label'					=> __( $this->plural, CUZTOM_TEXTDOMAIN ),
				'labels'				=> $labels,
				"hierarchical" 			=> true,
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
			),

			// Given
			$this->args

		);
		
		register_taxonomy( $this->name, $this->post_type_name, $args );
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
		register_taxonomy_for_object_type( $this->name, $this->post_type_name );
	}	
}