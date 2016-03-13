<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkbox extends Field
{
    use Checkable;

    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'checkbox';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-checkbox';

    /**
     * Output.
     *
     * @param  string|array $value
     * @return string
     * @since  3.0
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/checkbox', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
