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
		// Sortable
		add_action( 'wp_ajax_cuztom_add_repeatable_item', array( &$this, 'add_repeatable_item' ) );
		add_action( 'wp_ajax_cuztom_add_bundle_item', array( &$this, 'add_bundle_item' ) );

		// Save
		add_action( 'wp_ajax_cuztom_save_field', array( &$this, 'save_field' ) );
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
		$field = self::get_field( $_POST['cuztom']['field_id'] );

		if( ! $field ) {
			return;
		}

		if( !$field->limit || ($field->limit > $_POST['cuztom']['count']) ) {
			echo json_encode( array(
				'status' 	=> true,
				'item' 		=> $field->_output_repeatable_item( null, 10 )
			) );
		} else {
			echo json_encode( array(
				'status' 	=> false,
				'message' 	=> __('Limit reached!', 'cuztom')
			) );
		}

		// wp
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
		$field = self::get_field( $_POST['cuztom']['field_id'] );

		if( ! $field ) {
			return;
		}

		if( !$field->limit || ( $field->limit > $_POST['cuztom']['count'] ) ) {
			echo json_encode( array(
				'status' 	=> true,
				'item' 		=> $field->output_item( $_POST['cuztom']['index'] )
			) );
		} else {
			echo json_encode( array(
				'status' 	=> false,
				'message' 	=> __('Limit reached!', 'cuztom')
			) );
		}

		// wp
		die();
	}

	/**
	 * Saves a field
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 *
	 */
	function save_field()
	{
		global $cuztom;

		if( $_POST['cuztom'] && isset($_POST['cuztom']['id']) ) {
			$field = self::get_field( $_POST['cuztom']['id'] );

			echo '<pre>';
			var_dump($field);
			die();

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

		// wp
		die();
	}

	/**
	 * Get field object from cuztom global
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 *
	 */
	static function get_field($id)
	{
		global $cuztom;
		return $cuztom['fields'][$id];
	}
}