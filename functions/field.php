<?php

function cuztom_field( $field_id_name, $field, $meta )
{
	echo Cuztom_Field::output( $field_id_name, $field, $meta );
}

function _cuztom_field_supports_repeatable( $field )
{
	return Cuztom_Field::_supports_repeatable( $field );
}

?>