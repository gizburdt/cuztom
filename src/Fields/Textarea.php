<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Guard;
use Gizburdt\Cuztom\Cuztom;

Guard::blockDirectAccess();

class Textarea extends Field
{
    /**
     * Base.
     *
     * @var mixed
     */
    public $view = 'textarea';

    /**
     * Fillables.
     *
     * @var mixed
     */
    public $css_class = 'cuztom-input--textarea';
    public $cell_css_class = 'cuztom-field--textarea';
}
