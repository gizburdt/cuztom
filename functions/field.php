<?php

function cuztom_field( $field, $value )
{
	if( is_object( $field ) )
		echo $field->output( $value );
	else
		return false;
}

function _cuztom_field_supports_repeatable( $field )
{
	return $field->_supports_repeatable();
}

function _cuztom_field_supports_bundle( $field )
{
	return $field->_supports_bundle();
}