<?php

if (! defined('ABSPATH')) {
    exit;
}

class Cuztom_Field_Color extends Cuztom_Field
{
    public $_supports_ajax     = true;
    public $_supports_bundle   = true;
    public $css_classes        = array( 'js-cztm-colorpicker', 'cuztom-colorpicker', 'colorpicker', 'cuztom-input' );
}
