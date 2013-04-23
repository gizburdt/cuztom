<?php

if( ! defined( 'ABSPATH' ) ) exit;

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
	$taxonomy = new Cuztom_Taxonomy( $name, $post_type, $args, $labels );
	
	return $taxonomy;
}