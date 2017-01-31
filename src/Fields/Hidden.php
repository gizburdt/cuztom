<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Hidden extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'hidden';

    /**
     * Fillables.
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--hidden';

    /**
     * Hidden field only needs the field.
     * Not a cell.
     *
     * @param  string $value
     * @return string
     */
    public function outputCell($value = null)
    {
        return $this->outputInput($value);
    }
}
