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
	var $post_type_name;
	var $post_type_args;
	var $post_type_labels;
	
	
	/**
	 * Construct a new Custom Post Type
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
			$this->post_type_name		= Cuztom::uglify( $name );
			$this->post_type_args 		= $args;
			$this->post_type_labels 	= $labels;

			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->post_type_name ) )
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
		// Capitilize the words and make it plural
		$name 		= Cuztom::beautify( $this->post_type_name );
		$plural 	= Cuztom::pluralize( $name );

		// We set the default labels based on the post type name and plural. 
		// We overwrite them with the given labels.
		$labels = array_merge(

			// Default
			array(
				'name' 					=> _x( $plural, 'post type general name', CUZTOM_TEXTDOMAIN ),
				'singular_name' 		=> _x( $name, 'post type singular name', CUZTOM_TEXTDOMAIN ),
				'add_new' 				=> _x( 'Add New', strtolower( $name ), CUZTOM_TEXTDOMAIN ),
				'add_new_item' 			=> __( 'Add New ' . $name, CUZTOM_TEXTDOMAIN ),
				'edit_item' 			=> __( 'Edit ' . $name, CUZTOM_TEXTDOMAIN ),
				'new_item' 				=> __( 'New ' . $name, CUZTOM_TEXTDOMAIN ),
				'all_items' 			=> __( 'All ' . $plural, CUZTOM_TEXTDOMAIN ),
				'view_item' 			=> __( 'View ' . $name, CUZTOM_TEXTDOMAIN ),
				'search_items' 			=> __( 'Search ' . $plural, CUZTOM_TEXTDOMAIN ),
				'not_found' 			=> __( 'No ' . strtolower( $plural ) . ' found', CUZTOM_TEXTDOMAIN ),
				'not_found_in_trash' 	=> __( 'No ' . strtolower( $plural ) . ' found in Trash', CUZTOM_TEXTDOMAIN ), 
				'parent_item_colon' 	=> '',
				'menu_name' 			=> $plural
			),

			// Given labels
			$this->post_type_labels

		);

		// Same principle as the labels. We set some default and overwite them with the given arguments.
		$args = array_merge(

			// Default
			array(
				'label' 				=> $plural,
				'labels' 				=> $labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'supports' 				=> array( 'title', 'editor' ),
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
			),

			// Given args
			$this->post_type_args

		);

		// Register the post type
		register_post_type( $this->post_type_name, $args );
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
		$taxonomy = new Cuztom_Taxonomy( $name, $this->post_type_name, $args, $labels );
		
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
		$meta_box = new Cuztom_Meta_Box( $title, $fields, $this->post_type_name, $context, $priority );
		
		// For method chaining
		return $this;
	}	
}

?>