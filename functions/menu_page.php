<?php

/**
 * Adds a Menu Page
 *
 * @param 	string 			$page_title
 * @param 	string 			$menu_title
 * @param 	string 			$capability
 * @param 	string 			$menu_slug
 * @param 	string 			$function
 * @param 	string 			$icon_url
 * @param 	integer 		$position
 * @return 	object 			Cuztom_Menu_Page
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function add_cuztom_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = 100 )
{
	$menu_page = new Cuztom_Menu_Page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	
	return $menu_page;
}