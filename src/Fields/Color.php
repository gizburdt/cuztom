<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Color extends Field
{
    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--colorpicker colorpicker js-cuztom-colorpicker';
    public $cell_css_class = 'cuztom-field--color';
}
