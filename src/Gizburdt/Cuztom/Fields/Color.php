<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Color extends Field
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-colorpicker colorpicker js-cuztom-colorpicker';
}