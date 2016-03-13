<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-textarea';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-textarea';

    /**
     * Output input.
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/textarea', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
