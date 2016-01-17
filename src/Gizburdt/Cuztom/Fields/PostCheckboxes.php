<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Fields\Field;

if (! defined('ABSPATH')) {
    exit;
}

class PostCheckboxes extends Field
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
     * Constructs Cuztom_Field_Post_Checkboxes
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
                'post_type'            => 'post',
                'posts_per_page'    => -1
            ),
            $this->args
        );

        $this->default_value     = (array) $this->default_value;
        $this->posts             = get_posts($this->args);
        $this->after            .= '[]';
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
        $output = '<div class="cuztom-checkboxes-wrap">';
        if (is_array($this->posts)) {
            foreach ($this->posts as $post) {
                $output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id($this->id . $this->after_id . '_' . Cuztom::uglify($post->post_title)) . ' ' . $this->output_css_class() . ' value="' . $post->ID . '" ' . (is_array($value) ? (in_array($post->ID, $value) ? 'checked="checked"' : '') : (($value == '-1') ? '' : in_array($post->ID, $this->default_value) ? 'checked="checked"' : '')) . ' /> ';
                $output .= '<label for="' . $this->id . $this->after_id . '_' . Cuztom::uglify($post->post_title) . '">' . $post->post_title . '</label>';
                $output .= '<br />';
            }
        }
        $output .= '</div>';
        $output .= $this->output_explanation();

        return $output;
    }

    public function parse_value($value)
    {
        return empty($value) ? '-1' : $value;
    }
}
