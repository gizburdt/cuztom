<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers a Post Type
 *
 * @param 	string|array 	$name
 * @param 	array 			$args
 * @param 	array 			$labels
 * @return 	object 			Cuztom_Post_Type
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function register_cuztom_post_type( $name, $args = array(), $labels = array() )
{
	$post_type = new Cuztom_Post_Type( $name, $args, $labels );
	
	return $post_type;
}