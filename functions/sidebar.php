<?php

/**
 * Registers a sidebar
 *
 * @param 	string 			$name
 * @param 	string 			$id
 * @param 	string 			$description
 * @param 	string 			$before_widget
 * @param 	string 			$after_widget
 * @param 	string 			$before_title
 * @param 	string 			$after_title
 * @return 	object 			Cuztom_Sidebar
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
function register_cuztom_sidebar( $name, $id = '', $description = '', $before_widget = '', $after_widget = '', $before_title = '', $after_title = '' )
{
	$sidebar = new Cuztom_Sidebar( $name, $id, $description, $before_widget, $after_widget, $before_title, $after_title );
	
	return $sidebar;
}