<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates new field
 *
 * @param 	array 	$args
 *
 * @author 	Gijs Jorissen
 * @since 	3.0
 *
 */
function create_cuztom_field( $args )
{
	$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $args['type'] ) ) );

	if( class_exists( $class ) ) {
		return new $class( $args );
	}

	return false;
}