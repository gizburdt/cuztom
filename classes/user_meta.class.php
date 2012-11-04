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
	var $id;
	var $title;
	var $locations;
	var $data;
	var $fields;


	/**
	 * Constructor for User Meta
	 * 
	 * @param 	string 				$title
	 * @param 	string|array 		$locations
	 * @param 	array  				$data
	 *
	 * @author  Gijs Jorissen
	 * @since   1.5
	 * 
	 */
	function __construct( $title, $locations, $data = array() )
	{
		// Meta variables	
		$this->id 			= Cuztom::uglify( $title );
		$this->title 		= Cuztom::beautify( $title );
		$this->locations	= array( 'show_user_profile', 'edit_user_profile' );

		// Chack if the class, function or method exist, otherwise use cuztom callback
		if( Cuztom::_is_wp_callback( $data ) )
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
			if( is_object( $this->data ) && $this->data instanceof Cuztom_Bundle )
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
		if( is_object( $this->data ) && $this->data instanceof Cuztom_Bundle )
		{
			$value = isset( $_POST['cuztom'][$field->id] ) ? array_values( $_POST['cuztom'][$field->id] ) : '';
			$value = apply_filters( "cuztom_user_meta_save_bundle_$field->id", apply_filters( 'cuztom_user_meta_bundle', $value, $field, $user_id ), $field, $user_id );			

			add_user_meta( $user_id, $field->id, $value );
		}
		else
		{
			$value = isset( $_POST['cuztom'][$id_name] ) ? $_POST['cuztom'][$id_name] : '';

			if( $field instanceof Cuztom_Field_Wysiwyg ) $value = wpautop( $value );
			if( ( $field instanceof Cuztom_Field_Checkbox || $field instanceof Cuztom_Field_Checkboxes || $field instanceof Cuztom_Field_Post_Checkboxes || $field instanceof Cuztom_Field_Term_Checkboxes ) && empty( $value ) ) $value = '-1';

			$value = apply_filters( "cuztom_user_meta_save_$field->type", apply_filters( 'cuztom_user_meta_save', $value, $field, $user_id ), $field, $user_id );

			update_user_meta( $user_id, $id_name, $value );
		}
	}
}