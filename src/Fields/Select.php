<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * View name.
     * @var string
     */
    public $view = 'select';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select';

    /**
     * Cell CSS class.
     * @var string
     */
    public $cell_css_class = 'cuztom-field-select';
}
