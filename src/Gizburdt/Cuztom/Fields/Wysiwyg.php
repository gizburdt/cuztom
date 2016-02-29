<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Wysiwyg extends Field
{
    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        // Set necessary args
        @$this->args['editor_class'] .= ' cuztom-input';
        $this->args['textarea_name'] = $this->get_name();
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
        return wp_editor(
            (! Cuztom::is_empty($value) ? $value : $this->default_value),
            $this->get_id(),
            $this->args
        );
    }
}
