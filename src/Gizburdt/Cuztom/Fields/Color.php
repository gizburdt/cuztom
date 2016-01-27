<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Color extends Field
{
    public $css_class = 'js-cuztom-colorpicker cuztom-colorpicker colorpicker cuztom-input';
}