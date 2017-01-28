<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class TermSelect extends Field
{
    /**
     * Fillables.
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--term-select';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->args = array_merge(
            array(
                'taxonomy' => 'category'
            ),
            $this->args
        );
    }

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     */
    public function outputInput($value = null, $view = null)
    {
        @$this->args['class'] .= ' cuztom-input--select cuztom-input--term-select';

        @$this->args['echo']     = 0;
        @$this->args['name']     = $this->getName();
        @$this->args['id']       = $this->getId();
        @$this->args['selected'] = (! Cuztom::isEmpty($value) ? $value : $this->default_value);

        return wp_dropdown_categories($this->args);
    }
}
