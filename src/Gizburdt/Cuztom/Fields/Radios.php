<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Radios extends Field
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

        $this->after_name .= '[]';
    }

    /**
     * Output
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $ob    = '';
        $count = 0;

        $ob .= '<div class="cuztom-checkboxes cuztom-radios" '.$this->output_data_attributes().'>';
            if (is_array($this->options)) {
                foreach ($this->options as $slug => $name) {
                    $ob .= '<label for="'.$this->get_id().'_'.Cuztom::uglify($slug).'">';
                        $ob .= '<input type="radio" '.$this->output_name().' '.$this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . checked(!empty($value) ? $value : $this->default_value, $slug, false) . ' /> ';
                        $ob .= Cuztom::beautify($name);
                    $ob .= '</label>';
                    $ob .= '<br />';

                    $count++;
                }
            }
        $ob .= '</div>';
        $ob .= $this->output_explanation();

        return $ob;
    }

    /**
     * Parse value
     *
     * @param  string|array $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return is_array($value) ? @$value[0] : $value;
    }
}
