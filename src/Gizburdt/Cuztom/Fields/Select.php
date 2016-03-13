<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-select';

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

        Cuztom::view('fields/select', array(
            'field' => $this,
            'value' => $value,
            'i'     => $i
        ));
    }
}
