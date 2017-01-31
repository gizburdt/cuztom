<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkables;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkboxes extends Field
{
    use Checkables;

    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'checkbox';
    public $view      = 'checkboxes';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--checkbox';
    public $cell_css_class = 'cuztom-field--checkboxes';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->default_value = (array) $this->default_value;

        $this->afterName .= '[]';
    }
}
