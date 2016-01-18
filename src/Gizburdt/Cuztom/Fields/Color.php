<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Color extends Field
{
    public $_supports_ajax     = true;
    public $_supports_bundle   = true;
    public $css_classes        = array( 'js-cztm-colorpicker', 'cuztom-colorpicker', 'colorpicker', 'cuztom-input' );
}
