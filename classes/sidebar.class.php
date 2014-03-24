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
			'name'				=> isset( $args['name'] ) 			? $args['name'] 			: '',
			'id'				=> isset( $args['id'] ) 			? $args['id'] 				: '',
			'description'		=> isset( $args['description'] ) 	? $args['description'] 		: '',
			'class'				=> isset( $args['class'] ) 			? $args['class'] 			: '',
			'before_widget'		=> isset( $args['before_widget'] ) 	? $args['before_widget'] 	: '',
			'after_widget'		=> isset( $args['after_widget'] ) 	? $args['after_widget'] 	: '',
			'before_title'		=> isset( $args['before_title'] ) 	? $args['before_title'] 	: '',
			'after_title'		=> isset( $args['after_title'] ) 	? $args['after_title'] 		: '',
		);
		
		add_action( 'widgets_init', array( &$this, 'register_sidebar' ) );
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