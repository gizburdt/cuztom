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
	function __construct( $id, $title, $locations, $data = array() )
	{
		parent::__construct( $title );

		$this->id 			= $id;
		$this->locations	= array( 'show_user_profile', 'edit_user_profile' );

		// Chack if the class, function or method exist, otherwise use cuztom callback
		if( Cuztom::is_wp_callback( $data ) )
		{
			$this->callback = $data;
		}
		else
		{
			$this->callback = array( &$this, 'callback' );

			// Build the meta box and fields
			$this->data = $this->build( $data );

			add_action( 'personal_options_update', array( &$this, 'save_user' ) );
			add_action( 'edit_user_profile_update', array( &$this, 'save_user' ) );
			add_action( 'user_edit_form_tag', array( &$this, 'edit_form_tag' ) );
		}

		foreach( $this->locations as $location )
			add_action( $location, $this->callback );
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
	function callback( $user, $data = array() )
	{
		echo '<h3>' . $this->title . '</h3>';

		parent::callback( $user, $data );
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
		if( ! ( isset( $_POST['cuztom_nonce'] ) && wp_verify_nonce( $_POST['cuztom_nonce'], 'cuztom_meta' ) ) ) return;

		$values = isset( $_POST['cuztom'] ) ? $_POST['cuztom'] : array();

		if( ! empty( $values ) )
			parent::save( $user_id, $values );
	}

	/**
	 * Normal save method to save all the fields in a metabox
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.6
	 */
	function save( $user_id, $values )
	{
		foreach( $this->fields as $id => $field )
		{
			if( $field->in_bundle ) continue;
			
			$value = isset( $values[$id] ) ? $values[$id] : '';
			$value = apply_filters( "cuztom_user_meta_save_$field->type", apply_filters( 'cuztom_user_meta_save', $value, $field, $user_id ), $field, $user_id );

			$field->save( $user_id, $value, 'user' );
		}
	}
}