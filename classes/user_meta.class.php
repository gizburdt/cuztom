<?php

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
	 * @param   integer 		$id
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
			$this->_build( $data );

			add_action( 'personal_options_update', array( &$this, 'save_user' ) );
			add_action( 'edit_user_profile_update', array( &$this, 'save_user' ) );
			add_action( 'user_edit_form_tag', array( &$this, '_edit_form_tag' ) );
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
		if( ! ( isset( $_POST['cuztom_nonce'] ) && wp_verify_nonce( $_POST['cuztom_nonce'], plugin_basename( dirname( __FILE__ ) ) ) ) ) return;

		// Loop through each meta box
		if( ! empty( $this->data ) && isset( $_POST['cuztom'] ) )
		{
			if( $this->data instanceof Cuztom_Bundle && $field = $this->data )
			{
				delete_user_meta( $user_id, $this->id );
				
				$this->_save_meta( $user_id, $this, 0 );
			}
			else
			{
				foreach( $this->fields as $id_name => $field )
				{
					$this->_save_meta( $user_id, $field, $id_name );
				}
			}
		}		
	}

	/**
	 * Actual method that saves the user meta
	 *
	 * @param 	integer 			$user_id
	 * @param 	array 				$field  
	 * @param 	string 				$id_name
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.5
	 *
	 */
	function _save_meta( $user_id, $field, $id_name )
	{
		if( $this->data instanceof Cuztom_Bundle && $field = $this->data )
		{
			$value = isset( $_POST['cuztom'][$field->id] ) ? array_values( $_POST['cuztom'][$field->id] ) : '';
			$value = apply_filters( "cuztom_user_meta_save_bundle_$field->id", apply_filters( 'cuztom_user_meta_bundle', $value, $field, $user_id ), $field, $user_id );			

			$field->save( $user_id, $value, 'user' );
		}
		else
		{
			$value = isset( $_POST['cuztom'][$id_name] ) ? $_POST['cuztom'][$id_name] : '';
			$value = apply_filters( "cuztom_user_meta_save_$field->type", apply_filters( 'cuztom_user_meta_save', $value, $field, $user_id ), $field, $user_id );

			$field->save( $user_id, $value, 'user' );
		}
	}
}