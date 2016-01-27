<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class MultiSelect extends Field
{
    use Selectable;

    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input', 'cuztom-select', 'cuztom-multi-select' );

    /**
     * Constructs Cuztom_Field_Multi_Select
     *
     * @author 	Gijs Jorissen
     * @since 	0.3.3
     *
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->after           .= '[]';
    }

    /**
     * Output method
     *
     * @param  string|array $value
     * @return string
     */
    public function _output($value = null)
    {
        return $this->_output_input($value, null, ['multiselect' => true]) . $this->output_explanation();
    }
}
