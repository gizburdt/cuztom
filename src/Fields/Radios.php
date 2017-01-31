<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Radios extends Field
{
    use Checkable;

    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'radio';
    public $view      = 'radios';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--radio';
    public $cell_css_class = 'cuztom-field--radios';

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
    }

    /**
     * Parse value.
     *
     * @param  string|array $value
     * @return string
     */
    public function parseValue($value)
    {
        return is_array($value) ? @$value[0] : $value;
    }
}
