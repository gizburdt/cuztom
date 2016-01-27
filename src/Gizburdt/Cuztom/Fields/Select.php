<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * Css class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-select';

    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);
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
        return $this->_output_input($value) . $this->output_explanation();
    }
}
