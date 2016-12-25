<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Time extends DateTime
{
    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--time timepicker js-cuztom-timepicker';
    public $cell_css_class = 'cuztom-field--time';

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function timeToString($string)
    {
        return $string ? date(get_option('time_format'), $string) : null;
    }
}
