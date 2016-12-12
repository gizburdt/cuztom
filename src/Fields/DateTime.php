<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class DateTime extends Field
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-datetime datetimepicker js-cuztom-datetimepicker';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-datetime';

    /**
     * Data attributes.
     * @var array
     */
    public $data_attributes = array(
        'time-format' => null,
        'date-format' => null
    );

    /**
     * Construct.
     *
     * @param array $args
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->data_attributes['date-format'] = get_option('date_format');
        $this->data_attributes['time-format'] = get_option('time_format');

        // Convert value
        $this->value = $this->timeToString($this->value);
    }

    /**
     * Parse value.
     *
     * @param  string $value
     * @return string
     * @since  2.8
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
        return $this->value ? date(get_option('date_format').' '.get_option('time_format'), $this->value) : null;
    }
}
