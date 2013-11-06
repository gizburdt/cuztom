<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers sidebars
 *
 * @author 	Gijs Jorissen
 * @since 	0.5
 *
 */
class Cuztom_Sidebar
{
	var $args;
	
	/**
	 * Constructor
	 *
	 * @param 	array		$args
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.5
	 *
	 */
	function __construct( $args = array() )
	{
		$this->args = array(
			'name'				=> isset( $name['name'] ) 			? $name['name'] 			: '',
			'id'				=> isset( $name['id'] ) 			? $name['id'] 				: '',
			'description'		=> isset( $name['description'] ) 	? $name['description'] 		: '',
			'class'				=> isset( $name['class'] ) 			? $name['class'] 			: '',
			'before_widget'		=> isset( $name['before_widget'] ) 	? $name['before_widget'] 	: '',
			'after_widget'		=> isset( $name['after_widget'] ) 	? $name['after_widget'] 	: '',
			'before_title'		=> isset( $name['before_title'] ) 	? $name['before_title'] 	: '',
			'after_title'		=> isset( $name['after_title'] ) 	? $name['after_title'] 		: '',
		);
		
		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
	}
	
	/**
	 * Register the Sidebar
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	function register_sidebar()
	{
		register_sidebar( $this->args );
	}
}