<?php

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

/**
 * Adds extra string to field class
 *
 * @param  string $class
 * @param  object $field
 * @param  string $extra
 * @return string
 */
function cuztom_field_css_class_extra($class, $field, $extra)
{
    if (!Cuztom::is_empty($extra)) {
        return $class.' '.$extra;
    }

    return $class;
}
add_filter('cuztom_field_css_class', 'cuztom_field_css_class_extra', 10, 3);

/**
 * Adds extra string to field ID
 *
 * @param  string $id
 * @param  object $field
 * @param  string $extra
 * @return string
 */
function cuztom_field_id_extra($id, $field, $extra)
{
    if (! Cuztom::is_empty($extra)) {
        return $id.'_'.$extra;
    }

    return $id;
}
add_filter('cuztom_field_id', 'cuztom_field_id_extra', 10, 3);
