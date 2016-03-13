<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Radios extends Field
{
    use Checkable;

    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'radio';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-radio';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-radios';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->default_value = (array) $this->default_value;
        $this->after_name   .= '[]';
    }

    /**
     * Output input.
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/radios', array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Parse value.
     *
     * @param  string|array $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return is_array($value) ? @$value[0] : $value;
    }
}
