<?php

/**
 * Funcion to output a Cuztom_Field
 * 
 * @param  	object 			$field
 * @param  	string|array 	$value
 * @return 	mixed
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 * 
 */
function cuztom_field( $field, $value )
{
	if( is_object( $field ) )
		echo $field->output( $value );
	else
		return false;
}


/**
 * Check if a Cuztom_Field supports repeatable functionality
 * 
 * @param  	object 			$field
 * @return 	boolean
 *
 * @author  Gijs Jorissen
 * @since 	0.8
 * 
 */
function _cuztom_field_supports_repeatable( $field )
{
	return $field->_supports_repeatable();
}


/**
 * Check if a Cuztom_Field supports the bundle functionality
 * 
 * @param  	object 			$field
 * @return 	boolean
 *
 * @author  Gijs Jorissen
 * @since 	0.8
 * 
 */
function _cuztom_field_supports_bundle( $field )
{
	return $field->_supports_bundle();
}