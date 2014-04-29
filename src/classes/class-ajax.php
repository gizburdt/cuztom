<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Ajax controller
 *
 * @author  Gijs Jorissen
 * @since  	3.0
 */
class Cuztom_Ajax
{
	/**
	 * Add hooks
	 * 
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 * 
	 */
	function add_hooks()
	{
		// Field - sortable
		add_action( 'wp_ajax_cuztom_add_repeatable_item', array( &$this, 'add_repeatable_item' ) );		
		add_action( 'wp_ajax_cuztom_add_bundle_item', array( &$this, 'add_bundle_item' ) );

		// Field - save
		add_action( 'wp_ajax_cuztom_field_ajax_save', array( &$this, 'field_save_ajax' ) );
	}

	/**
	 * Add (return) repeatable item
	 * 
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 * 
	 */
	function add_repeatable_item()
	{
		global $cuztom;
		$field = $cuztom['fields'][$_POST['cuztom']['field_id']];

		if( ! $field )
			return;

		if( !$field->limit || ( $field->limit > $_POST['cuztom']['count'] ) )
			echo json_encode( array( 'status' => true, 'item' => $field->_output_repeatable_item() ) );
		else
			echo json_encode( array( 'status' => false, 'message' => __('Limit reached!') ) );

		die();
	}

	/**
	 * Add (return) bundle item
	 * 
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 * 
	 */
	function add_bundle_item()
	{
		global $cuztom;
		$field = $cuztom['fields'][$_POST['cuztom']['field_id']];

		if( ! $field )
			return;

		if( !$field->limit || ( $field->limit > $_POST['cuztom']['count'] ) )
			echo json_encode( array( 'status' => true, 'item' => $field->output_item() ) );
		else
			echo json_encode( array( 'status' => false, 'message' => __('Limit reached!') ) );

		die();
	}

	/**
	 * Saves a field
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 * 
	 */
	function field_save_ajax()
	{
		if( $_POST['cuztom'] )
		{
			$object_id	= $_POST['cuztom']['object_id'];
			$id			= $_POST['cuztom']['id'];
			$value 		= $_POST['cuztom']['value'];
			$meta_type 	= $_POST['cuztom']['meta_type'];

			if( empty( $object_id ) ) 
				die();

			if( $meta_type == 'user' )
				update_user_meta( $object_id, $id, $value );
			elseif( $meta_type == 'post' )
				update_post_meta( $object_id, $id, $value );
		}

		// For Wordpress
		die();
	}
}