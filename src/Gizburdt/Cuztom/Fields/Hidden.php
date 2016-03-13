<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Hidden extends Field
{
    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-hidden';

    /**
     * Hidden field only needs the field.
     * Not a row.
     *
     * @param  string $value
     * @return string
     * @since  0.2
     */
    public function output_row($value = null)
    {
        return $this->_output_input($value);
    }
}
