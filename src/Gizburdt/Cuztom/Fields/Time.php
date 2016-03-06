<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\DateTime;

Guard::directAccess();

class Time extends DateTime
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input-time timepicker js-cuztom-timepicker';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-time';
}
