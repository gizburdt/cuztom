<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Color extends Field
{
    /**
     * CSS class.
     *
     * @var string
     */
    public $css_class = 'cuztom-input-colorpicker colorpicker js-cuztom-colorpicker';

    /**
     * Row CSS class.
     *
     * @var string
     */
    public $row_css_class = 'cuztom-field-color';
}
