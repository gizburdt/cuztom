<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Checkboc extends Field
{
    /**
     * Output
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return '<div class="cuztom-checkbox">
            <input type="checkbox" '.$this->output_name().' '.$this->output_id().'" '.$this->output_css_class().' '.$this->output_checked($value).' value="on" />
        </div>'.$this->output_explanation();
    }

    /**
     * Output checked attribute
     *
     * @param  mixed $value
     * @return string
     * @since  3.0
     */
    public function output_checked($value = null)
    {
        return (! Cuztom::is_empty($value) ? checked($value, 'on', false) : checked($this->default_value, 'on', false));
    }

    /**
     * Parse value
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function parse_value($value)
    {
        return Cuztom::is_empty($value) ? '-1' : $value;
    }
}
