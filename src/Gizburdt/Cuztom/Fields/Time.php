<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Time extends DateTime
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-time timepicker js-cuztom-timepicker';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-time';

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function time_to_string($string)
    {
        return $this->_value ? date(get_option('time_format'), $this->_value) : null;
    }
}
