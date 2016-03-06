<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Hidden extends Field
{
    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-hidden';

    /**
     * Outputs a field row
     * Overwrite to output the hidden field without a row.
     *
     * @param string $vallue
     * @since 0.2
     *
     */
    public function output_row($value = null)
    {
        $this->output($value);
    }
}
