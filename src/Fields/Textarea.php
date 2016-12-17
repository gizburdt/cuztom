<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * View name.
     * @var string
     */
    public $view = 'textarea';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input--textarea';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field--textarea';
}
