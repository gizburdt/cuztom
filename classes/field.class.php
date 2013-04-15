<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Cuztom Field Class
 *
 * @author 	Gijs Jorissen
 * @since 	0.3.3
 *
 */
class Cuztom_Field
{
	var $id_name				= '';
	var $type					= '';
	var $name 					= '';
    var $label 					= '';
    var $description 			= '';
    var $explanation			= '';
	var $default_value 			= '';
	var $options 				= array();
	var $args					= array();
	var $hide 					= true;
	var $repeatable 			= false;
	var $ajax 					= false;
	var $show_admin_column 		= false;
	var $pre					= '';
	var $after					= '';
	var $parent					= '';

	var $_supports_repeatable 	= false;
	var $_supports_bundle		= false;
	var $_supports_ajax			= false; 

	/**
	 * Constructs a Cuztom_Field
	 * 
	 * @param 	array 			$field
	 * @param 	string 			$parent
	 * @param   object 			$object
	 *
	 * @author  Gijs Jorissen
	 * @since 	0.3.3
	 * 
	 */
	function __construct( $field, $parent, $object = null )
	{
		$this->name 				= isset( $field['name'] ) 				? $field['name'] 				: $this->name;
		$this->label				= isset( $field['label'] ) 				? $field['label'] 				: $this->label;
		$this->description			= isset( $field['description'] ) 		? $field['description'] 		: $this->description;
		$this->explanation			= isset( $field['explanation'] ) 		? $field['explanation'] 		: $this->explanation;
		$this->type					= isset( $field['type'] ) 				? $field['type'] 				: $this->type;
		$this->hide					= isset( $field['hide'] ) 				? $field['hide'] 				: $this->hide;
		$this->default_value		= isset( $field['default_value'] ) 		? $field['default_value'] 		: $this->default_value;
		$this->options				= isset( $field['options'] ) 			? $field['options'] 			: $this->options;
		$this->args					= isset( $field['args'] ) 				? $field['args'] 				: $this->args;
		$this->repeatable			= isset( $field['repeatable'] ) 		? $field['repeatable'] 			: $this->repeatable ;
		$this->ajax					= isset( $field['ajax'] ) 				? $field['ajax'] 				: $this->ajax ;
		$this->show_admin_column	= isset( $field['show_admin_column'] ) 	? $field['show_admin_column'] 	: $this->show_admin_column;
		
		// Mostly the name of the meta box
		$this->parent				= $parent;
		
		// Id_name is used as id to select the field
		// If i'ts not in the $field paramater, the id_name will be genereted
		$this->id_name 				= isset( $field['id_name'] ) 			? $field['id_name'] 			: $this->_build_id_name( $this->name, $parent );
	}
	
	/**
	 * Outputs a field based on its type
	 *
	 * @param 	string|array 	$value
	 * @param   object 			$object
	 * @return  mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	function output( $value, $object )
	{
		if( $this->repeatable && $this->_supports_repeatable )
			return $this->_repeatable_output( $value, $object );
		elseif( $this->ajax && $this->_supports_ajax )
			return $this->_ajax_output( $value, $object );
		else
			return $this->_output( $value, $object );
	}

	/**
	 * Outputs the field, ready for repeatable functionality
	 * 
	 * @param  	string|array 	$value
	 * @param   object 			$object
	 * @return  mixed 			$output
	 *
	 * @author  Gijs Jorissen
	 * @since   2.0
	 * 
	 */
	function _repeatable_output( $value, $object )
	{
		$this->after = '[]';
		$output = '';

		if( is_array( $value ) )
		{
			foreach( $value as $item )
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $item, $object ) . ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>' . $this->_output( $value, $object ) . ( $this->repeatable ? '</li>' : '' );		
		}

		return $output;
	}

	/**
	 * Outputs the field, ready for ajax save
	 * 
	 * @param  	string|array 	$value
	 * @param   object 			$object
	 * @return  mixed 			$output
	 *
	 * @author  Gijs Jorissen
	 * @since   2.0
	 * 
	 */
	function _ajax_output( $value, $object )
	{
		$output = $this->_output( $value, $object );
		$output .= sprintf( '<a class="cuztom-ajax-save js-cuztom-ajax-save button-secondary" href="#">%s</a>', __( 'Save', 'cuztom' ) );

		return $output;
	}

	/**
	 * Save meta
	 * 
	 * @param  	int 			$post_id
	 * @param  	string 			$value
	 * @param   string 			$meta_type
	 *
	 * @author 	Gijs Jorissen
	 * @since  	1.6.2
	 * 
	 */
	function save( $id, $value, $meta_type )
	{
		if( $meta_type == 'user' )
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
			$meta_type 	= $_POST['cuztom']['meta_type'];

			if( empty( $id ) ) 
				die();

			if( $meta_type == 'user' )
				update_user_meta( $id, $id_name, $value );
			else
				update_post_meta( $id, $id_name, $value );
		}

		// For Wordpress
		die();
	}
	
	/**
	 * Builds an string used as field id and name
	 *
	 * @param 	string 			$name
	 * @param  	string 			$parent
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.9
	 *
	 */
	function _build_id_name( $name, $parent )
	{		
		return apply_filters( 'cuztom_build_id_name', ( $this->hide ? '_' : '' ) . Cuztom::uglify( $parent ) . "_" . Cuztom::uglify( $name ) );
	}
}