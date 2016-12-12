<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Wysiwyg extends Field
{
    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-wysiwyg';

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _outputInput($value = null, $view = null)
    {
        // Needs to be set here, to work with sortables
        @$this->args['textarea_name'] = $this->getName();
        @$this->args['editor_class'] .= ' cuztom-input';

        return wp_editor(
            (! Cuztom::isEmpty($value) ? $value : $this->default_value),
            strtolower($this->getId()),
            $this->args
        );
    }
}
