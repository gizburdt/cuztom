<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Date extends DateTime
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-date datepicker js-cuztom-datepicker';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-date';

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function time_to_string($string)
    {
        return $this->value ? date(get_option('date_format'), $this->value) : null;
    }
}
