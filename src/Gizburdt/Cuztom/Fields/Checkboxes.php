<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Checkboxes extends Field
{
    public $_supports_bundle           = true;
    public $css_classes                = array( 'cuztom-input' );

    /**
     * Constructs Cuztom_Field_Checkboxes
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->default_value = (array) $this->default_value;
        $this->after_name   .= '[]';
    }

    /**
     * Output method
     * @param  mixed  $value [description]
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $output = '<div class="cuztom-checkboxes-wrap">';
        if (is_array($this->options)) {
            foreach ($this->options as $slug => $name) {
                $output .= '<label ' . $this->output_for_attribute($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . '>';
                $output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . (is_array($value) ? (in_array($slug, $value) ? 'checked="checked"' : '') : (($value == '-1') ? '' : in_array($slug, $this->default_value) ? 'checked="checked"' : '')) . ' /> ';
                $output .= Cuztom::beautify($name);
                $output .= '</label>';
                $output .= '<br />';
            }
        }
        $output .= '</div>';

        $output .= $this->output_explanation();

        return $output;
    }

    /**
     * Parse value
     * @param  mixed  $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return empty($value) ? '-1' : $value;
    }
}
