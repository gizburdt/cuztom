<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-select';
}
