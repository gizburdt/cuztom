<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Fields\Field;

if (! defined('ABSPATH')) {
    exit;
}

class Select extends Field
{
    /**
     * Feature support
     */
    public $_supports_repeatable    = true;
    public $_supports_ajax            = true;
    public $_supports_bundle        = true;

    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input cuztom-select' );
    public $data_attributes        = array( 'default-value' => null );

    /**
     * Constructs Cuztom_Field_Select
     *
     * @author 	Gijs Jorissen
     * @since   0.3.3
     *
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->data_attributes['default-value'] = $this->default_value;
    }

    /**
     * Output method
     *
     * @return  string
     *
     * @author 	Gijs Jorissen
     * @since 	2.4
     *
     */
    public function _output($value = null)
    {
        $output = '<div class="cuztom-select-wrap"><select ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' ' . $this->output_data_attributes() . '>';
        if (isset($this->args['show_option_none'])) {
            $output .= '<option value="0" ' . (empty($value) ? 'selected="selected"' : '') . '>' . $this->args['show_option_none'] . '</option>';
        }

        if (is_array($this->options)) {
            foreach ($this->options as $slug => $name) {
                $output .= '<option value="' . $slug . '" ' . ((isset($value) && strlen($value) > 0) ? selected($slug, $value, false) : selected($this->default_value, $slug, false)) . '>' . Cuztom::beautify($name) . '</option>';
            }
        }
        $output .= '</select></div>';
        $output .= $this->output_explanation();

        return $output;
    }
}
