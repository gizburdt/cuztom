<?php

/**
 * Class to register Menu Pages
 *
 * @author 	Gijs Jorissen
 * @since 	0.4
 *
 */
class Cuztom_Menu_Page extends Cuztom_Page
{
	var $icon_url;
	var $position;
	
	/**
	 * Constructor
	 *
	 * @param 	string 			$page_title
	 * @param 	string 			$menu_title
	 * @param 	string 			$capability
	 * @param 	string 			$menu_slug
	 * @param 	string 			$function
	 * @param 	string 			$icon_url
	 * @param 	integer 		$position
	 *
	 * @author 	Gijs Jorissen 
	 * @since 	0.4
	 *
	 */
	function __construct( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url = '', $position = 100 )
	{
		$this->page_title = Cuztom::beautify( $page_title );
		$this->menu_title = Cuztom::beautify( $menu_title );
		$this->capability = $capability;
		$this->menu_slug = Cuztom::uglify( $menu_slug );
		$this->function = $function;
		$this->icon_url = $icon_url;
		$this->position = $position;
		
		add_action( 'admin_menu', array( $this, 'register_menu_page' ) );
	}
	
	/**
	 * Hooked function to regster the menu page
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4
	 *
	 */
	function register_menu_page()
	{
		add_menu_page( 
			$this->page_title, 
			$this->menu_title, 
			$this->capability, 
			$this->menu_slug, 
			$this->function, 
			$this->icon_url,
			$this->position
		);
	}
	
	/**
	 * Add submenu page to the current parent page
	 * Method chaining is possible
	 *
	 * @param 	string 			$page_title
	 * @param 	string 			$menu_title
	 * @param 	string 			$capability
	 * @param 	string 			$menu_slug
	 * @param 	string 			$functions
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4
	 *
	 */
	function add_submenu_page( $page_title, $menu_title, $capability, $menu_slug, $function )
	{
		$submenu = new Cuztom_Submenu_Page( $this->menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		
		// For method chaining
		return $this;
	}
}