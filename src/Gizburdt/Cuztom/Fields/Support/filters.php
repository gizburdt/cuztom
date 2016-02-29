<?php

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

function cuztom_field_output_css_class_extra($class, $field, $extra)
{
    if (!Cuztom::is_empty($extra)) {
        return $class.' '.$extra;
    }

    return $class;
}
add_filter('cuztom_field_output_css_class', 'cuztom_field_output_css_class_extra', 10, 3);
