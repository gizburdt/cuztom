<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-textarea';

    /**
     * Output input
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        return '<textarea
            name="'  .$this->get_name(). '"
            id="'    .$this->get_id(). '"
            class="' .$this->get_css_class(). '"
            '        .$this->get_data_attributes(). '
            >'       .$this->get_value($value). '</textarea>';
    }
}
