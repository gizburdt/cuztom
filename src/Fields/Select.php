<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * Base.
     * @var mixed
     */
    public $view = 'select';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class = 'cuztom-input--select';
    public $cell_css_class = 'cuztom-field--select';
}
