<?php

/**
 * Cuztom class to create submenus
 *
 * @author 	Gijs Jorissen
 * @since 	0.4
 *
 */
class Cuztom_Submenu_Page extends Cuztom_Page
{
	var $parent_slug;
	
	/**
	 * Constructor
	 *
	 * @param 	string 			$parent_slug
	 * @param 	string 			$page_title
	 * @param 	string 			$menu_title
	 * @param 	string 			$capability
	 * @param 	string 			$menu_slug
	 * @param 	string 			$function
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4
	 *
	 */
	function __construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' )
	{
		$this->parent_slug = $parent_slug;
		$this->page_title = Cuztom::beautify( $page_title );
		$this->menu_title = Cuztom::beautify( $menu_title );
		$this->capability = $capability;
		$this->menu_slug = Cuztom::uglify( $menu_slug );
		$this->function = $function;
		
		add_action( 'admin_menu', array( $this, 'register_submenu_page' ) );
	}
	
	/**
	 * Calls the add submenu page
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4
	 *
	 */
	function register_submenu_page()
	{
		add_submenu_page(
			$this->parent_slug,
			$this->page_title, 
			$this->menu_title, 
			$this->capability, 
			$this->menu_slug, 
			$this->function
		);
	}
}