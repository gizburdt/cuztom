<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class MultiSelect extends Select
{
    use Selectable;

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select cuztom-input-multi-select';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-multi-select';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->after_name          .= '[]';
        $this->args['multiselect']  = true;
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
        $i = 0;

        Cuztom::view('fields/multi-select', array(
            'field' => $this,
            'value' => $value,
            'i'     => $i
        ));
    }
}
