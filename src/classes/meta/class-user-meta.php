<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * User Meta
 *
 * @author 	Gijs Jorissen
 * @since 	1.5
 *
 */
class Cuztom_User_Meta extends Cuztom_Meta
{
	var $locations;

	var $meta_type = 'user';

	/**
	 * Constructor for User Meta
	 *
	 * @param   string 			$id
	 * @param 	string|array	$title
	 * @param 	string|array 	$locations
	 * @param 	array  			$data
	 *
	 * @author  Gijs Jorissen
	 * @since   1.5
	 *
	 */
	function __construct( $id, $data = array(), $locations = array( 'show_user_profile', 'edit_user_profile' ) )
	{
		// Build all properties
		parent::__construct( $id, $data );

		// Set locations
		$this->locations 	= (array) $locations;

		// Chack if the class, function or method exist, otherwise use cuztom callback
		if( ! $this->callback ) {
			$this->callback = array( &$this, 'output' );

			// Build the meta box and fields
			$this->data = $this->build( $this->fields );

			add_action( 'personal_options_update', array( &$this, 'save_user' ) );
			add_action( 'edit_user_profile_update', array( &$this, 'save_user' ) );
			add_action( 'user_edit_form_tag', array( &$this, 'edit_form_tag' ) );
		}

		foreach( $this->locations as $location ) {
			add_action( $location, $this->callback );
		}
	}

	/**
	 * Callback for user meta, adds a title
	 *
	 * @param  	int     			$user [description]
	 * @param  	array    	$data [description]
	 *
	 * @author  Gijs Jorissen
	 * @since   1.5
	 *
	 */
	function callback( $user, $data = array(), $args = array() )
	{
		echo '<h3>' . $this->title . '</h3>';

		parent::callback( $user, $this->data, $args );
	}

	/**
	 * Hooks into the save hook for the user meta
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.5
	 *
	 */
	function save_user( $user_id )
	{
		// Verify nonce
		if( ! (isset( $_POST['cuztom_nonce']) && wp_verify_nonce($_POST['cuztom_nonce'], 'cuztom_meta')) ) {
			return;
		}

		$values = isset($_POST['cuztom']) ? $_POST['cuztom'] : array();

		if( !empty($values) ) {
			parent::save( $user_id, $values );
		}
	}

	/**
	 * Get object ID
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function get_object_id()
	{
		if( isset( $_GET['user_id'] ) ) {
			return $_GET['user_id']; // @TODO: Use get_current_screen()
		}

		return null;
	}

	/**
	 * Get value bases on field id
	 *
	 * @return  field
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function get_meta_values()
	{
		return get_user_meta( $this->object );
	}
}