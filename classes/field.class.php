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
	var $id_name			= '';
	var $name 				= '';
    var $label 				= '';
	var $type				= '';
    var $description 		= '';
    var $explanation		= '';
	var $hide 				= true;
	var $default_value 		= '';
	var $options 			= array();
	var $args				= array();
	var $repeatable 		= false;
	var $ajax 				= false;
	var $show_admin_column 	= false;
	var $pre				= '';
	var $after				= '';
	var $context			= '';

	var $_supports_repeatable 	= false;
	var $_supports_bundle		= false;
	var $_supports_ajax			= false; 

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
	function __construct( $field, $context, $post = null )
	{
		$this->name 				= isset( $field['name'] ) ? $field['name'] : $this->name;
		$this->label				= isset( $field['label'] ) ? $field['label'] : $this->label;
		$this->description			= isset( $field['description'] ) ? $field['description'] : $this->description;
		$this->explanation			= isset( $field['explanation'] ) ? $field['explanation'] : $this->explanation;
		$this->type					= isset( $field['type'] ) ? $field['type'] : $this->type;
		$this->hide					= isset( $field['hide'] ) ? $field['hide'] : $this->hide;
		$this->default_value		= isset( $field['default_value'] ) ? $field['default_value'] : $this->default_value;
		$this->options				= isset( $field['options'] ) ? $field['options'] : $this->options;
		$this->args					= isset( $field['args'] ) ? $field['args'] : $this->args;
		$this->repeatable			= isset( $field['repeatable'] ) ? $field['repeatable'] : $this->repeatable ;
		$this->ajax					= isset( $field['ajax'] ) ? $field['ajax'] : $this->ajax ;
		$this->show_admin_column	= isset( $field['show_admin_column'] ) ? $field['show_admin_column'] : $this->show_admin_column;
		$this->context				= $context;
		
		$this->id_name 				= $this->_build_id_name( $this->name, $context );
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
		if( $this->repeatable && $this->_supports_repeatable )
			return $this->_repeatable_output( $value );
		elseif( $this->ajax && $this->_supports_ajax )
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
		if( $_POST['cuztom'] )
		{
			$id 		= $_POST['cuztom']['id'];
			$id_name 	= $_POST['cuztom']['id_name'];
			$value 		= $_POST['cuztom']['value'];
			$context 	= $_POST['cuztom']['context'];

			if( empty( $id ) ) 
				die();

			if( $context == 'user' )
				update_user_meta( $id, $id_name, $value );
			else
				update_post_meta( $id, $id_name, $value );
		}

		// For Wordpress
		die();
	}

	/**
	 * Outputs the field, ready for ajax save
	 * 
	 * @param  	string|array 	$value
	 * @return  mixed 			$output
	 *
	 * @author  Gijs Jorissen
	 * @since   2.0
	 * 
	 */
	function _ajax_output( $value )
	{
		$output = $this->_output( $value );
		$output .= sprintf( '<a class="cuztom-ajax-save js-cuztom-ajax-save button-secondary" href="#">%s</a>', __( 'Save', 'cuztom' ) );

		return $output;
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