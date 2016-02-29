<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class TermSelect extends Field
{
    /**
     * Construct field
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

        $this->args['class']    .= ' cuztom-input cuztom-select cuztom-term-select';
        $this->args['echo']     = 0;
        $this->args['name']     = $this->get_name() . ($this->is_repeatable() ? '[]' : '');
        $this->args['id']       = $this->get_id();;
        $this->args['selected'] = (! Cuztom::is_empty($value) ? $value : $this->default_value);
    }

    /**
     * Output input
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        return wp_dropdown_categories($this->args);
    }
}
