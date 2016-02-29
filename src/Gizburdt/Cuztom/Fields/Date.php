<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\DateTime;

Guard::directAccess();

class Date extends DateTime
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-datepicker datepicker js-cuztom-datepicker';
}
