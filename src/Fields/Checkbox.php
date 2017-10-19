<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Guard;

Guard::blockDirectAccess();

class Checkbox extends Field
{
    use Checkable;

    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'checkbox';
    public $view      = 'checkbox';

    /**
     * Fillables.
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--checkbox';
}
