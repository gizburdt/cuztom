<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Checkboxes extends Field
{
    /**
     * Css class
     * @var string
     */
    public $css_classes = 'cuztom-input';

    /**
     * Construct
     *
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
     * Output
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $ob = '<div class="cuztom-checkboxes-wrap">';
            if (is_array($this->options)) {
                foreach ($this->options as $slug => $name) {
                    $ob .= '<label ' . $this->output_for_attribute($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . '>';
                    $ob .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . (is_array($value) ? (in_array($slug, $value) ? 'checked="checked"' : '') : (($value == '-1') ? '' : in_array($slug, $this->default_value) ? 'checked="checked"' : '')) . ' /> ';
                    $ob .= Cuztom::beautify($name);
                    $ob .= '</label>';
                    $ob .= '<br />';
                }
            }
        $ob .= '</div>';
        $ob .= $this->output_explanation();

        return $ob;
    }

    /**
     * Parse value
     *
     * @param  string $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return Cuztom::is_empty($value) ? '-1' : $value;
    }
}
