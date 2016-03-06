<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class DateTime extends Field
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input-datetime datetimepicker js-cuztom-datetimepicker';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-datetime';

    /**
     * Data attributes
     * @var array
     */
    public $data_attributes = array(
        'time-format' => 'H',
        'date-format' => null
    );

    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->data_attributes['date-format'] = get_option('date_format');
        $this->data_attributes['time-format'] = get_option('time_format');
    }

    /**
     * Parse value
     *
     * @param  string $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return strtotime($value);
    }
}
