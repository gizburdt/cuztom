<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * Css class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-textarea';

    /**
     * Output method
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return '<textarea '.$this->output_name().' '.$this->output_id().' '.$this->output_css_class().'>'.(strlen($value) > 0 ? $value : $this->default_value).'</textarea>'.$this->output_explanation();
    }
}
