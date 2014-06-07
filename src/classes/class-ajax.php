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
		add_action( 'wp_ajax_cuztom_field_ajax_save', array( &$this, 'field_ajax_save' ) );
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

		if( ! $field ) {
			return;
		}

		if( !$field->limit || ( $field->limit > $_POST['cuztom']['count'] ) ) {
			echo json_encode( array( 'status' => true, 'item' => $field->_output_repeatable_item() ) );
		} else {
			echo json_encode( array( 'status' => false, 'message' => __('Limit reached!') ) );
		}

		// For Wordpress
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

		if( ! $field ) {
			return;
		}

		if( !$field->limit || ( $field->limit > $_POST['cuztom']['count'] ) ) {
			echo json_encode( array( 'status' => true, 'item' => $field->output_item( $_POST['cuztom']['index'] ) ) );
		} else {
			echo json_encode( array( 'status' => false, 'message' => __('Limit reached!') ) );
		}

		// For Wordpress
		die();
	}

	/**
	 * Saves a field
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 * 
	 */
	function field_ajax_save()
	{
		global $cuztom;
		
		if( $_POST['cuztom'] && ( empty( $object_id ) || empty( $id ) ) )
		{
			$object		= $_POST['cuztom']['object_id'];
			$id			= $_POST['cuztom']['id'];
			$value 		= $_POST['cuztom']['value'];
			$meta_type 	= $_POST['cuztom']['meta_type'];
			$field 		= $cuztom['fields'][$id];
			
			if( $field->save( $object, $value ) ) {
				echo json_encode( array( 'status' => true ) );
			} else {
				echo json_encode( array( 'status' => false ) );
			}
		}

		// For Wordpress
		die();
	}
}