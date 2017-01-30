<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Date extends DateTime
{
    /**
     * Fillables.
     * @var mixed
     */
    public $css_class       = 'cuztom-input--date datepicker js-cuztom-datepicker';
    public $cell_css_class  = 'cuztom-field--date';
    public $html_attributes = array(
        'data-date-format' => null
    );

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function timeToString($string)
    {
        return $string ? date(get_option('date_format'), $string) : null;
    }
}
