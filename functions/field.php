<?php

function cuztom_field( $value )
{
	echo Cuztom_Field::output( $value );
}

function _cuztom_field_supports_repeatable( $field )
{
	return call_user_func( array($field, '_supports_repeatable') );
}

function _cuztom_field_supports_bundle( $field )
{
	return call_user_func( array($field, '_supports_bundle') );
}