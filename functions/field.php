<?php

function cuztom_field( $field_id_name, $field, $meta = '', $pre = '', $after = '' )
{
	echo Cuztom_Field::output( $field_id_name, $field, $meta, $pre, $after );
}

function _cuztom_field_supports_repeatable( $field )
{
	return Cuztom_Field::_supports_repeatable( $field );
}

?>