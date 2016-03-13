<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class TermCheckboxes extends Checkboxes
{
    /**
     * Terms.
     * @var array
     */
    public $terms;

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-term-checkboxes';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->args = array_merge(
            array(
                'taxonomy'   => 'category',
                'hide_empty' => 0
            ),
            $this->args
        );

        $this->terms         = get_terms($this->args['taxonomy'], array('hide_empty' => false));
        $this->default_value = (array) $this->default_value;
    }

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/term-checkboxes', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
