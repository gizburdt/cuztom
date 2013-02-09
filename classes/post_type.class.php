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

			$this->args 		= $args;
			$this->labels 		= $labels;
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
			array(
				'name' 					=> sprintf( _x( '%s', 'post type general name', 'cuztom' ), $this->plural ),
				'singular_name' 		=> sprintf( _x( '%s', 'post type singular title', 'cuztom' ), $this->title ),
				'menu_name' 			=> sprintf( __( '%s', 'cuztom' ), $this->plural ),
				'all_items' 			=> sprintf( __( 'All %s', 'cuztom' ), $this->plural ),
				'add_new' 				=> sprintf( _x( 'Add New', '%s', 'cuztom' ), $this->title ),
				'add_new_item' 			=> sprintf( __( 'Add New %s', 'cuztom' ), $this->title ),
				'edit_item' 			=> sprintf( __( 'Edit %s', 'cuztom' ), $this->title ),
				'new_item' 				=> sprintf( __( 'New %s', 'cuztom' ), $this->title ),
				'view_item' 			=> sprintf( __( 'View %s', 'cuztom' ), $this->title ),
				'items_archive'			=> sprintf( __( '%s Archive', 'cuztom' ), $this->title ),
				'search_items' 			=> sprintf( __( 'Search %s', 'cuztom' ), $this->plural ),
				'not_found' 			=> sprintf( __( 'No %s found', 'cuztom' ), $this->plural ),
				'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'cuztom' ), $this->plural ),
				'parent_item_colon'		=> sprintf( __( '%s Parent', 'cuztom' ), $this->title ),
			),
			$this->labels
		);

		// Post type arguments
		$args = array_merge( 
			array(
				'label' 				=> sprintf( __( '%s', 'cuztom' ), $this->plural ),
				'labels' 				=> $labels,
				'public' 				=> true,
				'supports' 				=> array( 'title', 'editor' ),
				'has_archive'           => sanitize_title( $this->plural )
			),
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
	 * @param   integer 		$id
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
	function add_meta_box( $id, $title, $fields = array(), $context = 'normal', $priority = 'default' )
	{
		// Call Cuztom_Meta_Box with this post type name as second parameter
		$meta_box = new Cuztom_Meta_Box( $id, $title, $this->name, $fields, $context, $priority );
		
		// For method chaining
		return $this;
	}

	/**
	 * Add action to register support of certain features for a post type.
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
	
	/**
	 * Check if post type supports a certain feature
	 *
	 * @param 	string  		$feature    		The feature to check support for
	 * @return  boolean 
	 * 
	 * @author 	Abhinav Sood
	 * @since 	1.5.3
	 * 
	 */
	function post_type_supports( $feature )
	{
	    return post_type_supports( $this->name, $feature );
	}
}
