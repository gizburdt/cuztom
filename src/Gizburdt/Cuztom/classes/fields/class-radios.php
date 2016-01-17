<?php

if (! defined('ABSPATH')) {
    exit;
}

class Cuztom_Field_Radios extends Cuztom_Field
{
    public $_supports_bundle   = true;
    public $css_classes        = array( 'cuztom-input' );
    public $data_attributes    = array( 'default-value' => null );

    /**
     * Constructs Cuztom_Field_Radios
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->data_attributes['default-value']  = $this->default_value;
        $this->after_name                       .= '[]';
    }

    /**
     * Output method
     * @param  mixed $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $output = '';
        $i      = 0;

        $output .= '<div class="cuztom-checkboxes cuztom-radios" ' . $this->output_data_attributes() . '>';
        if (is_array($this->options)) {
            foreach ($this->options as $slug => $name) {
                $output .= '<label ' . $this->output_for_attribute($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . '">';
                $output .= '<input type="radio" ' . $this->output_name() . ' ' . $this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($slug)) . ' ' . $this->output_css_class() . ' value="' . $slug . '" ' . checked(!empty($value) ? $value : $this->default_value, $slug, false) . ' /> ';
                $output .= Cuztom::beautify($name);
                $output .= '</label>';
                $output .= '<br />';
                $i++;
            }
        }
        $output .= '</div>';
        $output .= $this->output_explanation();

        return $output;
    }

    /**
     * Parse value
     * @param  array $value
     * @return mixed
     * @since  2.8
     */
    public function parse_value($value)
    {
        return @$value[0];
    }
}
