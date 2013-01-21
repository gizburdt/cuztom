<?php

/**
 * Registers sidebars
 *
 * @author 	Gijs Jorissen
 * @since 	0.5
 *
 */
class Cuztom_Sidebar
{
	var $sidebar;
	var $name;
	var $id;
	var $description;
	var $before_widget;
	var $after_widget;
	var $before_title;
	var $after_title;
	
	/**
	 * Constructor
	 *
	 * @param 	string|array	$name
	 * @param 	string 			$description
	 * @param 	string 			$before_widget
	 * @param 	string 			$after_widget
	 * @param 	string 			$before_title
	 * @param 	string 			$after_title
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.5
	 *
	 */
	function __construct( $name, $id = '', $description = '', $before_widget = '', $after_widget = '', $before_title = '', $after_title = '' )
	{
		if( is_array( $name ) )
		{
			$this->sidebar = array(
				'name'				=> $name['name'],
				'id'				=> isset( $name['id'] ) ? $name['id'] : '',
				'description'		=> isset( $name['description'] ) ? $name['description'] : '',
				'before_widget'		=> isset( $name['before_widget'] ) ? $name['before_widget'] : '',
				'after_widget'		=> isset( $name['after_widget'] ) ? $name['after_widget'] : '',
				'before_title'		=> isset( $name['before_title'] ) ? $name['before_title'] : '',
				'after_title'		=> isset( $name['after_title'] ) ? $name['after_title'] : '',
			);
		}
		else
		{
			$this->name = Cuztom::beautify( $name );
			$this->id = $id ? Cuztom::uglify( $id ) : Cuztom::uglify( $this->name );
			$this->description = $description;
			$this->before_widget = $before_widget;
			$this->after_widget = $after_widget;
			$this->before_title = $before_title;
			$this->after_title = $after_title;
		}
		
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
		$args = ( $this->sidebar )
			? $this->sidebar 
			: array(
				'name' => $this->name,
				'id' => $this->id,
				'description' => $this->description,
				'before_widget' => $this->before_widget,
				'after_widget' => $this->after_widget,
				'before_title' => $this->before_title,
				'after_title' => $this->after_title,
			);
		
		register_sidebar( $args );
	}
}