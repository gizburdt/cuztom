<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class YesNo extends Field
{
    /**
     * Css class
     * @var string
     */
    public $css_classes = 'cuztom-input';

    /**
     * Output
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $ob = '<div class="cuztom-checkboxes">';
            foreach (array('yes', 'no') as $answer) {
                $ob .= '<input type="radio" '.$this->output_name().' id="'.$this->get_id().'_'.$answer.'" '.$this->output_css_class().' value="'.$answer.'" '.(! Cuztom::is_empty($value) ? checked($value, $answer, false) : checked($this->default_value, $answer, false)).' /> ';
                $ob .= sprintf('<label for="%s_%s">%s</label>', $this->get_id(), $answer, ($answer == 'yes' ? __('Yes', 'cuztom') : __('No', 'cuztom')));
                $ob .= '<br />';
            }
        $ob .= '</div>';
        $ob .= $this->output_explanation();

        return $ob;
    }
}
