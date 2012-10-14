<?php

/**
 * Adds a Meta Box to a Post Type
 *
 * @param 	string 			$title
 * @param 	strin 			$post_type_name
 * @param 	array 			$fields
 * @param 	string 			$context
 * @param 	string 			$priority
 * @return 	object 			Cuztom_Meta_Box
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function add_cuztom_meta_box( $title, $post_type_name, $fields = array(), $context = 'normal', $priority = 'default' )
{
	$meta_box = new Cuztom_Meta_Box( $title, $post_type_name, $fields, $context, $priority );
	
	return $meta_box;
}