<?php

/**
 * Registers a Taxonomy for a Post Type
 *
 * @param 	string 			$name
 * @param 	string 			$post_type_name
 * @param 	array 			$args
 * @param 	array 			$labels
 * @return 	object 			Cuztom_Taxonomy
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function register_cuztom_taxonomy( $name, $post_type_name, $args = array(), $labels = array() )
{
	$taxonomy = new Cuztom_Taxonomy( $name, $post_type_name, $args, $labels );
	
	return $taxonomy;
}