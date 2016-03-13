<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkables;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkboxes extends Field
{
    use Checkables;

    /**
     * Css class.
     * @var string
     */
    public $_input_type = 'checkbox';

    /**
     * Css class.
     * @var string
     */
    public $css_class = 'cuztom-input-checkbox';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-checkboxes';

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
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/checkboxes', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
