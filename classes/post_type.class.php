<?php

/**
 * Post Type class used to register post types
 * Can call add_taxonomy and add_meta_box to call the associated classes
 * Method chaining is possible
 *
 * @author Gijs jorissen
 * @since 0.1
 *
 */
class Cuztom_Post_Type
{
	var $name;
	var $args;
	var $labels;
	
	
	/**
	 * Construct a new Cuztom Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function __construct( $name, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			// Set some important variables
			$this->name		= Cuztom::uglify( $name );
			$this->args 	= $args;
			$this->labels 	= $labels;

			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->name ) )
			{
				add_action( 'init', array( &$this, 'register_post_type' ) );
			}
		}
	}
	
	
	/**
	 * Register the Post Type
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function register_post_type()
	{		
		// Capitilize and pluralize
		$name 		= Cuztom::beautify( $this->name );
		$plural 	= Cuztom::pluralize( $name );

		// Set labels
		$labels = array_merge(

			// Default
			array(
				'name' 					=> _x( $plural, 'post type general name', CUZTOM_TEXTDOMAIN ),
				'singular_name' 		=> _x( $name, 'post type singular name', CUZTOM_TEXTDOMAIN ),
				'add_new' 				=> _x( 'Add New', $name, CUZTOM_TEXTDOMAIN ),
				'add_new_item' 			=> sprintf( __( 'Add New %s', CUZTOM_TEXTDOMAIN ), $name ),
				'edit_item' 			=> sprintf( __( 'Edit %s', CUZTOM_TEXTDOMAIN ), $name ),
				'new_item' 				=> sprintf( __( 'New %s', CUZTOM_TEXTDOMAIN ), $name ),
				'all_items' 			=> sprintf( __( 'All %s', CUZTOM_TEXTDOMAIN ), $plural ),
				'view_item' 			=> sprintf( __( 'View %s', CUZTOM_TEXTDOMAIN ), $name ),
				'search_items' 			=> sprintf( __( 'Search %s', CUZTOM_TEXTDOMAIN ), $plural ),
				'not_found' 			=> sprintf( __( 'No %s found', CUZTOM_TEXTDOMAIN ), $plural ),
				'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', CUZTOM_TEXTDOMAIN ), $plural ),
				'menu_name' 			=> __( $plural, CUZTOM_TEXTDOMAIN )
			),

			// Given labels
			$this->labels

		);

		// Post type arguments
		$args = array_merge(

			// Default
			array(
				'label' 				=> __( $plural, CUZTOM_TEXTDOMAIN ),
				'labels' 				=> $labels,
				'public' 				=> true,
				'supports' 				=> array( 'title', 'editor' ),
			),

			// Given args
			$this->args

		);

		// Register the post type
		register_post_type( $this->name, $args );
	}
	
	
	/**
	 * Add a taxonomy to the Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function add_taxonomy( $name, $args = array(), $labels = array() )
	{
		// Call Cuztom_Taxonomy with this post type name as second parameter
		$taxonomy = new Cuztom_Taxonomy( $name, $this->name, $args, $labels );
		
		// For method chaining
		return $this;
	}
	
	
	/**
	 * Add post meta box to the Post Type
	 *
	 * @param string $title
	 * @param array $fields
	 * @param string $context
	 * @param string $priority
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function add_meta_box( $title, $fields = array(), $context = 'normal', $priority = 'default' )
	{
		// Call Cuztom_Meta_Box with this post type name as second parameter
		$meta_box = new Cuztom_Meta_Box( $title, $this->name, $fields, $context, $priority );
		
		// For method chaining
		return $this;
	}	
}