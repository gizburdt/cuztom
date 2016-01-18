<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class YesNo extends Field
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
        $output = '';

        $output .= '<div class="cuztom-checkboxes">';
        foreach (array( 'yes', 'no' ) as $answer) {
            $output .= '<input type="radio" ' . $this->output_name() . ' ' . $this->output_id($this->before_id . $this->id . $this->after_id . '_' . $answer) . ' ' . $this->output_css_class() . ' value="' . $answer . '" ' . (! empty($value) ? checked($value, $answer, false) : checked($this->default_value, $answer, false)) . ' /> ';
            $output .= sprintf('<label for="%s_yes">%s</label>', $this->id, ($answer == 'yes' ? __('Yes', 'cuztom') : __('No', 'cuztom')));
            $output .= '<br />';
        }
        $output .= '</div>';
        $output .= $this->output_explanation();

        return $output;
    }
}
