<?php

/**
 * Cuztom Field Class
 *
 * @author 	Gijs Jorissen
 * @since 	0.3.3
 *
 */
class Cuztom_Field
{
	var $id_name		= '';
	var $name 			= '';
    var $label 			= '';
	var $type			= '';
    var $description 	= '';
	var $hide 			= true;
	var $default_value 	= '';
	var $options 		= array();
	var $repeatable 	= false;
	var $ajax 			= false;
	var $show_column 	= false;
	var $pre			= '';
	var $after			= '';
	var $context		= '';
	
	/**
	 * Constructs a Cuztom_Field
	 * 
	 * @param 	array 			$field
	 * @param 	string 			$context
	 *
	 * @author  Gijs Jorissen
	 * @since 	0.3.3
	 * 
	 */
	function __construct( $field, $context )
	{
		$this->name 			= isset( $field['name'] ) ? $field['name'] : $this->name;
		$this->label			= isset( $field['label'] ) ? $field['label'] : $this->label;
		$this->description		= isset( $field['description'] ) ? $field['description'] : $this->description;
		$this->type				= isset( $field['type'] ) ? $field['type'] : $this->type;
		$this->hide				= isset( $field['hide'] ) ? $field['hide'] : $this->hide;
		$this->default_value	= isset( $field['default_value'] ) ? $field['default_value'] : $this->default_value;
		$this->options			= isset( $field['options'] ) ? $field['options'] : $this->options;
		$this->repeatable		= isset( $field['repeatable'] ) ? $field['repeatable'] : $this->repeatable ;
		$this->ajax				= isset( $field['ajax'] ) ? $field['ajax'] : $this->ajax ;
		$this->show_column		= isset( $field['show_column'] ) ? $field['show_column'] : $this->show_column;
		$this->context			= $context;
		
		$this->id_name 			= $this->_build_id_name( $this->name, $context );
	}
	
	/**
	 * Outputs a field based on its type
	 *
	 * @param 	string|array 	$value
	 * @return  mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function output( $value )
	{
		if( $this->repeatable && $this->_supports_repeatable() && is_array( $value ) )
			return $this->_repeatable_output( $value );
		elseif( $this->ajax && $this->_supports_ajax() )
			return $this->_ajax_output( $value );
		else
			return $this->_output( $value );
	}

	/**
	 * Save meta
	 * 
	 * @param  	int 			$post_id
	 * @param  	string 			$value
	 *
	 * @author 	Gijs Jorissen
	 * @since  	1.6.2
	 * 
	 */
	function save( $id, $value, $context )
	{
		if( $context == 'user' )
			update_user_meta( $id, $this->id_name, $value );
		else
			update_post_meta( $id, $this->id_name, $value );
	}

	/**
	 * Saves an ajax field
	 * 
	 * @author  Gijs Jorissen
	 * @since  	2.0
	 * 
	 */
	function ajax_save()
	{
		$id 		= $_POST['id'];
		$id_name 	= $_POST['id_name'];
		$value 		= $_POST['value'];
		$context 	= $_POST['context'];

		if( empty( $id ) ) die();

		if( $context == 'user' )
			update_user_meta( $id, $id_name, $value );
		else
			update_post_meta( $id, $id_name, $value );

		// For Wordpress
		die();
	}
	
	/**
	 * Checks if the field supports repeatable functionality
	 *
	 * @return 	boolean
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.0
	 *
	 */
	function _supports_repeatable()
	{
		return in_array( $this->type, apply_filters( 'cuztom_supports_repeatable', array( 'text', 'textarea', 'select', 'post_select', 'term_select' ) ) );
	}
	
	/**
	 * Checks if the field supports bundle functionality
	 *
	 * @return 	boolean
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.2
	 *
	 */
	function _supports_bundle()
	{		
		return in_array( $this->type, apply_filters( 'cuztom_supports_bundle', array( 'text', 'textarea' ) ) );
	}

	/**
	 * Checks if the field supports ajax
	 * 
	 * @return  boolean
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.0
	 * 
	 */
	function _supports_ajax()
	{
		return in_array( $this->type, apply_filters( 'cuztom_supports_ajax', array( 'text' ) ) );	
	}
	
	/**
	 * Builds an string used as field id and name
	 *
	 * @param 	string 			$name
	 * @param  	string 			$context
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.9
	 *
	 */
	function _build_id_name( $name, $context )
	{		
		return apply_filters( 'cuztom_build_id_name', ( $this->hide ? '_' : '' ) . Cuztom::uglify( $context ) . "_" . Cuztom::uglify( $name ) );
	}
}