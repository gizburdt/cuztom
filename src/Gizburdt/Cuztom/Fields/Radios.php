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
     * View name.
     * @var string
     */
    public $view = 'radios';

    /**
     * Input type.
     * @var string
     */
    public $_input_type = 'radio';

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
    public function __construct($args, $values = null)
    {
        parent::__construct($values);

        $this->default_value = (array) $this->default_value;
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
