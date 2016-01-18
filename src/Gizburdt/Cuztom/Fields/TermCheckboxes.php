<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class TermCheckboxes extends Field
{
    /**
     * Feature support
     */
    public $_supports_bundle        = true;

    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input' );

    /**
     * Terms
     */
    public $terms;

    /**
     * Constructs Cuztom_Field_Term_Checkboxes
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
            ),
            $this->args
        );

        $this->default_value = (array) $this->default_value;
        $this->after_name    .= '[]';

        $this->get_taxonomy_terms();
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
        $output = '<div class="cuztom-checkboxes">';
        if (is_array($this->terms)) {
            foreach ($this->terms as $term) {
                $output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($term->name)) . ' ' . $this->output_css_class() . ' value="' . $term->term_id . '" ' . (is_array($value) ? (in_array($term->term_id, $value) ? 'checked="checked"' : '') : (($value == '-1') ? '' : in_array($term->term_id, $this->default_value) ? 'checked="checked"' : '')) . ' /> ';
                $output .= '<label for="' . $this->id . $this->after_id . '_' . Cuztom::uglify($term->name) . '">' . $term->name . '</label>';
                $output .= '<br />';
            }
        }
        $output .= '</div>';
        $output .= $this->output_explanation();

        return $output;
    }

    /**
     * Parse value
     *
     * @param 	string 		$value
     *
     * @author  Gijs Jorissen
     * @since 	2.8
     *
     */
    public function parse_value($value)
    {
        return empty($value) ? '-1' : $value;
    }

    /**
     * Gets taxonomy terms for use in the output
     *
     * @author 	Abhinav Sood
     * @since 	1.6.1
     *
     */
    public function get_taxonomy_terms()
    {
        $this->terms = get_terms($this->args['taxonomy'], $this->args);
    }
}
