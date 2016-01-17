<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Fields\Field;

if (! defined('ABSPATH')) {
    exit;
}

class Textarea extends Field
{
    /**
     * Feature support
     */
    public $_supports_repeatable    = true;
    public $_supports_bundle        = true;
    public $_supports_ajax            = true;

    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input', 'cuztom-textarea' );

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
        return '<textarea ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . '>' . (strlen($value) > 0 ? $value : $this->default_value) . '</textarea>' . $this->output_explanation();
    }
}
