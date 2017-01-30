<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class DateTime extends Field
{
    /**
     * Fillables.
     * @var mixed
     */
    public $css_class       = 'cuztom-input--datetime datetimepicker js-cuztom-datetimepicker';
    public $cell_css_class  = 'cuztom-field--datetime';
    public $html_attributes = array(
        'data-time-format' => null,
        'data-date-format' => null
    );

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        if (array_key_exists('data-date-format', $this->html_attributes)) {
            $this->html_attributes['data-date-format'] = get_option('date_format');
        }

        if (array_key_exists('data-time-format', $this->html_attributes)) {
            $this->html_attributes['data-time-format'] = get_option('time_format');
        }

        // Convert value
        $this->value = $this->timeToString($this->value);
    }

    /**
     * Parse value.
     *
     * @param  string $value
     * @return string
     */
    public function parseValue($value)
    {
        return Cuztom::time($value);
    }

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function timeToString($string)
    {
        return $this->value ? date(get_option('date_format').' '.get_option('time_format'), $string) : null;
    }
}
