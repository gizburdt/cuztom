<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Menu page class used to create menu page
 *
 * @author 	Gijs Jorissen
 * @since 	0.1
 *
 */
class Cuztom_Post_Type
{
	var $page_title;
	var $menu_title;
	var $capability;
	var $menu_slug;
	var $function;
	var $icon_url;
	var $position;
	
	/**
	 * Construct a new Cuztom Menu Page
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
			// If $name is an array, the first element is the singular name, the second is the plural name
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
			$this->add_features	= $this->remove_features = array();

			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->name ) )
			{
				$this->register_post_type();
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
}
