<?php

if( ! defined( 'ABSPATH' ) ) exit;

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
     * @param string|array $name
     * @param array        $args
     * @param array        $labels
     * @since 0.1
     */
    function __construct( $name, $args = array(), $labels = array() )
    {
        if( is_array( $name ) ) {
            $this->name     = Cuztom::uglify( $name[0] );
            $this->title    = Cuztom::beautify( $name[0] );
            $this->plural   = Cuztom::beautify( $name[1] );
        } else {
            $this->name     = Cuztom::uglify( $name );
            $this->title    = Cuztom::beautify( $name );
            $this->plural   = Cuztom::pluralize( Cuztom::beautify( $name ) );
        }

        // Set properties
        $this->args         = $args;
        $this->labels       = $labels;
        $this->add_features = $this->remove_features = array();

        // Register
        if( ! post_type_exists( $this->name ) ) {
            add_action( 'init', array( &$this, 'register_post_type' ) );
        }
    }

    /**
     * Register Post Type
     *
     * @since 0.1
     */
    function register_post_type()
    {
        if( $reserved = Cuztom::is_reserved_term( $this->name ) ) {
            new Cuztom_Notice( $reserved->get_error_message(), 'error' );
        } else {
            $labels = array_merge(
                array(
                    'name'                  => sprintf( _x( '%s', 'post type general name', 'cuztom' ), $this->plural ),
                    'singular_name'         => sprintf( _x( '%s', 'post type singular title', 'cuztom' ), $this->title ),
                    'menu_name'             => sprintf( __( '%s', 'cuztom' ), $this->plural ),
                    'all_items'             => sprintf( __( 'All %s', 'cuztom' ), $this->plural ),
                    'add_new'               => sprintf( _x( 'Add New', '%s', 'cuztom' ), $this->title ),
                    'add_new_item'          => sprintf( __( 'Add New %s', 'cuztom' ), $this->title ),
                    'edit_item'             => sprintf( __( 'Edit %s', 'cuztom' ), $this->title ),
                    'new_item'              => sprintf( __( 'New %s', 'cuztom' ), $this->title ),
                    'view_item'             => sprintf( __( 'View %s', 'cuztom' ), $this->title ),
                    'items_archive'         => sprintf( __( '%s Archive', 'cuztom' ), $this->title ),
                    'search_items'          => sprintf( __( 'Search %s', 'cuztom' ), $this->plural ),
                    'not_found'             => sprintf( __( 'No %s found', 'cuztom' ), $this->plural ),
                    'not_found_in_trash'    => sprintf( __( 'No %s found in trash', 'cuztom' ), $this->plural ),
                    'parent_item_colon'     => sprintf( __( '%s Parent', 'cuztom' ), $this->title ),
                ),
                $this->labels
            );

            // Post type arguments
            $args = array_merge(
                array(
                    'label'                 => sprintf( __( '%s', 'cuztom' ), $this->plural ),
                    'labels'                => $labels,
                    'public'                => true,
                    'supports'              => array( 'title', 'editor' ),
                    'has_archive'           => sanitize_title( $this->plural )
                ),
                $this->args
            );

            // Register the post type
            register_post_type( $this->name, $args );
        }
    }

    /**
     * Add a taxonomy to the Post Type
     *
     * @param string|array $name
     * @param array        $args
     * @param array        $labels
     * @since 0.1
     */
    function add_taxonomy( $name, $args = array(), $labels = array() )
    {
        $taxonomy = new Cuztom_Taxonomy( $name, $this->name, $args, $labels );

        return $this;
    }

    /**
     * Add post meta box to the Post Type
     *
     * @param integer $id
     * @param array   $args
     * @since 0.1
     */
    function add_meta_box( $id, $args )
    {
        $box = new Cuztom_Meta_Box( $id, $args, $this->name );

        return $this;
    }

    /**
     * Add action to register support of certain features for a post type.
     *
     * @param  string|array $feature
     * @return object
     * @since  1.4.3
     */
    function add_post_type_support( $feature )
    {
        add_post_type_support( $this->name, $feature );

        return $this;
    }

    /**
     * Add action to remove support of certain features for a post type.
     *
     * @param  string|array $feature
     * @return object
     * @since  1.4.3
     */
    function remove_post_type_support( $features )
    {
        foreach( (array) $features as $feature ) {
            remove_post_type_support( $this->name, $feature );
        }

        return $this;
    }

    /**
     * Check if post type supports a certain feature
     *
     * @param  string|array $feature
     * @return boolean
     * @since  1.5.3
     */
    function post_type_supports( $feature )
    {
        return post_type_supports( $this->name, $feature );
    }
}