<?php

/**
 * Adds a Submenu Page
 *
 * @param 	string 			$parent_slug
 * @param 	string 			$page_title
 * @param 	string 			$menu_title
 * @param 	string 			$capability
 * @param 	string 			$menu_slug
 * @param 	string 			$function
 * @return 	object 			Cuztom_Submenu_Page
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function add_cuztom_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' )
{
	$submenu_page = new Cuztom_Submenu_Page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	
	return $submenu_page;
}