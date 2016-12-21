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
    public $input_type = 'hidden';

    /**
     * Cell CSS class.
     * @var string
     */
    public $cell_css_class = 'cuztom-field-hidden';

    /**
     * Hidden field only needs the field.
     * Not a cell.
     *
     * @param  string $value
     * @return string
     * @since  0.2
     */
    public function outputCell($value = null)
    {
        return $this->_outputInput($value);
    }
}
