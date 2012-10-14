<?php

/**
 * Post Type class used to register post types
 * Can call add_taxonomy and add_meta_box to call the associated classes
 * Method chaining is possible
 *
 * @author 	Gijs Jorissen
 * @since 	0.1
 *
 */
class Cuztom_Post_Type
{
	var $name;
	var $title;
	var $plural;
	var $args;
	var $labels;
	var $add_features;
	var $remove_features;
	
	
	/**
	 * Construct a new Cuztom Post Type
	 *
	 * @param 	string|array 	$name
	 * @param 	array 			$args
	 * @param 	array 			$labels
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	function __construct( $name, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			// If $name is an array, the first element is the normal name, the second is the plural name
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

			$this->args 	= $args;
			$this->labels 	= $labels;
			$this->add_features	= $this->remove_features	= array();

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
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	function register_post_type()
	{
		// Set labels
		$labels = array_merge(

			// Default
			array(
				'name' 					=> _x( $this->plural, 'post type general name', CUZTOM_TEXTDOMAIN ),
				'singular_name' 		=> _x( $this->title, 'post type singular title', CUZTOM_TEXTDOMAIN ),
				'add_new' 				=> _x( 'Add New', $this->title, CUZTOM_TEXTDOMAIN ),
				'add_new_item' 			=> sprintf( __( 'Add New %s', CUZTOM_TEXTDOMAIN ), $this->title ),
				'edit_item' 			=> sprintf( __( 'Edit %s', CUZTOM_TEXTDOMAIN ), $this->title ),
				'new_item' 				=> sprintf( __( 'New %s', CUZTOM_TEXTDOMAIN ), $this->title ),
				'all_items' 			=> sprintf( __( 'All %s', CUZTOM_TEXTDOMAIN ), $this->plural ),
				'view_item' 			=> sprintf( __( 'View %s', CUZTOM_TEXTDOMAIN ), $this->title ),
				'search_items' 			=> sprintf( __( 'Search %s', CUZTOM_TEXTDOMAIN ), $this->plural ),
				'not_found' 			=> sprintf( __( 'No %s found', CUZTOM_TEXTDOMAIN ), $this->plural ),
				'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', CUZTOM_TEXTDOMAIN ), $this->plural ),
				'menu_name' 			=> __( $this->plural, CUZTOM_TEXTDOMAIN )
			),

			// Given labels
			$this->labels

		);

		// Post type arguments
		$args = array_merge(

			// Default
			array(
				'label' 				=> __( $this->plural, CUZTOM_TEXTDOMAIN ),
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
	 * @param 	string|array 	$name
	 * @param 	array 			$args
	 * @param 	array 			$labels
	 * @return  object 			Cuztom_Post_Type
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
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
	 * @param 	string 			$title
	 * @param 	array 			$fields
	 * @param 	string 			$context
	 * @param 	string 			$priority
	 * @return  object 			Cuztom_Post_Type
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	function add_meta_box( $title, $fields = array(), $context = 'normal', $priority = 'default' )
	{
		// Call Cuztom_Meta_Box with this post type name as second parameter
		$meta_box = new Cuztom_Meta_Box( $title, $this->name, $fields, $context, $priority );
		
		// For method chaining
		return $this;
	}
	

	/**
	 * Add action to register support of certain features for a post type.
	 *
	 * All features are directly associated with a functional area of the edit screen, such as the
	 * editor or a meta box: 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author',
	 * 'excerpt', 'page-attributes', 'thumbnail', and 'custom-fields'.
	 *
	 * Additionally, the 'revisions' feature dictates whether the post type will store revisions,
	 * and the 'comments' feature dictates whether the comments count will show on the edit screen.
	 *
	 * @param 	string|array 	$feature 			The feature being added, can be an array of feature strings or a single string
	 * @return 	object 			Cuztom_Post_Type
	 *
	 * @author 	Abhinav Sood
	 * @since 	1.4.3
	 * 
	 */
	function add_post_type_support( $feature )
	{
		$this->add_features	= (array) $feature;
		add_action( 'init', array( &$this, '_add_post_type_support' ) );
		
		// For method chaining
		return $this;
	}
	

	/**
	 * Register support of certain features for a post type.
	 * 
	 * @author 	Abhinav Sood
	 * @since 	1.4.3
	 * 
	 */
	function _add_post_type_support() 
	{
		add_post_type_support( $this->name, $this->add_features );
	}
	

	/**
	 * Add action to remove support of certain features for a post type.
	 *
	 * All features are directly associated with a functional area of the edit screen, such as the
	 * editor or a meta box: 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author',
	 * 'excerpt', 'page-attributes', 'thumbnail', and 'custom-fields'.
	 *
	 * Additionally, the 'revisions' feature dictates whether the post type will store revisions,
	 * and the 'comments' feature dictates whether the comments count will show on the edit screen.
	 *
	 * @param 	string|array 	$feature 			The feature being removed, can be an array of feature strings or a single string
	 * @return 	object 			Cuztom_Post_Type
	 * 
	 * @author 	Abhinav Sood
	 * @since 	1.4.3
	 * 
	 */
	function remove_post_type_support( $feature )
	{
		$this->remove_features	= (array) $feature;
		add_action( 'init', array( &$this, '_remove_post_type_support' ) );
		
		// For method chaining
		return $this;
	}
	

	/**
	 * Remove support of certain features for a post type.
	 * 
	 * @author 	Abhinav Sood
	 * @since 	1.4.3
	 * 
	 */
	function _remove_post_type_support()
	{
		foreach( $this->remove_features as $feature )
		{
			remove_post_type_support( $this->name, $feature );
		}
	}
}