<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Fields\Field;

if (! defined('ABSPATH')) {
    exit;
}

class TermSelect extends Field
{
    /**
     * Feature support
     */
    public $_supports_repeatable    = true;
    public $_supports_ajax            = true;
    public $_supports_bundle        = true;

    /**
     * Constructs Cuztom_Field_Term_Select
     *
     * @author 	Gijs Jorissen
     * @since 	0.3.3
     *
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->args = array_merge(
            array(
                'taxonomy'        => 'category',
                'hide_empty'    => 0
            ),
            $this->args
        );

        $this->args['class']    .= ' cuztom-input cuztom-select cuztom-term-select';
        $this->args['echo']        = 0;
        $this->args['name']    = 'cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name . ($this->is_repeatable() ? '[]' : '');
        $this->args['id']        = $this->before_id . $this->id . $this->after_id;
        $this->args['selected'] = (! empty($value) ? $value : $this->default_value);
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
        $output  = wp_dropdown_categories($this->args);
        $output .= $this->output_explanation();

        return $output;
    }
}
