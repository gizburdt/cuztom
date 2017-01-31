<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $view = 'textarea';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--textarea';
    public $cell_css_class = 'cuztom-field--textarea';
}
