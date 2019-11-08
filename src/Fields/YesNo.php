<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Checkable;

Guard::directAccess();

class YesNo extends Field
{
    use Checkable;

    /**
     * Base.
     * @var mixed
     */
    public $view = 'yes-no';
    public $inputType = 'radio';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class = 'cuztom-input--radio';
    public $cell_css_class = 'cuztom-field--yesno';
}
