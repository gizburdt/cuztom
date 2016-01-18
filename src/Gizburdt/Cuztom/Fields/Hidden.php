<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Hidden extends Field
{
    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input' );

    /**
     * Outputs a field row
     * Overwrite to output the hidden field without a row.
     *
     * @author 	Gijs Jorissen
     * @since 	0.2
     *
     */
    public function output_row($value = null)
    {
        $this->output($value);
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
        return '<input type="hidden" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' ' . $this->output_value($value) . ' ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
    }
}
