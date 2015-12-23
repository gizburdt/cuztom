<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( ! function_exists( 'register_cuztom_post_type' ) ) {
    /**
     * Register a Post Type
     *
     * @param  string $name
     * @param  array  $args
     * @param  array  $labels
     * @return object
     */
    function register_cuztom_post_type( $name, $args = array(), $labels = array() )
    {
        return new Cuztom_Post_Type( $name, $args, $labels );
    }
}

if( ! function_exists( 'register_cuztom_meta_box' ) ) {
    /**
     * Register met box
     *
     * @param  string       $id
     * @param  array        $data
     * @param  string|array $post_type
     * @return object
     */
    function register_cuztom_meta_box( $id, $data = array(), $post_type )
    {
        return new Cuztom_Meta_Box( $id, $data, $post_type );
    }
}