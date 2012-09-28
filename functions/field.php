<?php

function cuztom_field( $value )
{
	echo Cuztom_Field::output( $value );
}

function _cuztom_field_supports_repeatable( $field )
{
	return $field::_supports_repeatable();
}

function _cuztom_field_supports_bundle( $field )
{
	return $field::_supports_bundle();
}