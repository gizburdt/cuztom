<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers a Post Type
 *
 * @param 	string|array 	$menu_title
 * @param 	array 			$args
 * @param 	array 			$labels
 * @return 	object 			Cuztom_Menu_Page
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function register_cuztom_menu_page( $menu_title, $args = array(), $labels = array() )
{
	$menu_page = new Cuztom_Menu_Page( $menu_title, $args, $labels );
	
	return $menu_page;
}