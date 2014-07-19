<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( ! function_exists( 'register_cuztom_taxonomy' ) ) {

    /**
     * Registers a Taxonomy for a Post Type
     *
     * @param 	string 			$name
     * @param 	string 			$post_type
     * @param 	array 			$args
     * @param 	array 			$labels
     * @return 	object 			Cuztom_Taxonomy
     *
     * @author 	Gijs Jorissen
     * @since 	0.8
     *
     */
    function register_cuztom_taxonomy( $name, $post_type, $args = array(), $labels = array() )
    {
    	return new Cuztom_Taxonomy( $name, $post_type, $args, $labels );
    }
}

if( ! function_exists( 'get_cuztom_term_meta' ) ) {

    /**
     * Get term meta
     * 
     * @param   int|string 		$term     	Can be the id or the slug of the term
     * @param   string 			$taxonomy
     * @param   string 			$key
     * @return  string|array
     *
     * @author 	Gijs Jorissen
     * @since 	2.5
     */
    function get_cuztom_term_meta( $term, $taxonomy, $key = null )
    {
        if( empty( $taxonomy ) || empty( $term ) ) {
            return false;
        }
        
        if( ! is_numeric( $term ) ) {
        	$term = get_term_by( 'slug', $term, $taxonomy );
        	$term = $term->term_id;
        }

        $meta = '';

        if( $key ) {
            $meta = get_option( 'term_meta_' . $taxonomy . '_' . $term );

            if( ! empty( $meta[$key] ) ) {
                return $meta[$key]; 
            }
        } else {
            $query = $wpdb->query("SELECT FROM " . $wpdb->options . " WHERE option_name LIKE 'term_meta_%'");
            $meta = $query;
        }
            
        return $meta;
    }
}

if( ! function_exists( 'the_cuztom_term_meta' ) ) {

    /**
     * Get term meta
     * 
     * @param   int|string 		$term     	Can be the id or the slug of the term
     * @param   string 			$taxonomy
     * @param   string 			$key
     *
     * @author 	Gijs Jorissen
     * @since 	2.5
     */
    function the_cuztom_term_meta( $term, $taxonomy, $key = null )
    {
        if( empty( $term ) || empty( $taxonomy ) ) {
            return false;
        }

        echo get_cuztom_term_meta( $term, $taxonomy, $key );
    }
}

if( ! function_exists( 'update_cuztom_term_meta' ) ) {

    /**
     * Update term meta
     *
     * @author  Gijs Jorissen
     * @since   3.0
     */
    function update_cuztom_term_meta( $term, $taxonomy, $key, $value )
    {
        if( empty( $taxonomy ) || empty( $term ) ) {
            return false;
        }
        
        if( ! is_numeric( $term ) ) {
            $term = get_term_by( 'slug', $term, $taxonomy );
            $term = $term->term_id;
        }

        $option     = 'term_meta_' . $taxonomy . '_' . $term;
        $meta       = get_option( $option_name );

        if( $key ) {
            $meta[$key] = $value;
            update_option( $option, $meta );
        } else {
            update_option( $option, $value );
        }
    }
}

