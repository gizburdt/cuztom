<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class File extends Field
{
    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-hidden';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-file';

    /**
     * Output input.
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/file', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
