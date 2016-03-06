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
    public $css_class = 'cuztom-input-date datepicker js-cuztom-datepicker';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-date';
}
