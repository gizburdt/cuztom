<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Wysiwyg extends Field
{
    /**
     * Fillables.
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--wysiwyg';

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     */
    public function outputInput($value = null, $view = null)
    {
        // Needs to be set here, to work with sortables
        @$this->args['textarea_name'] = $this->getName();
        @$this->args['editor_class'] .= ' cuztom-input js-cuztom-wysiwyg';

        return wp_editor(
            (! Cuztom::isEmpty($value) ? $value : $this->default_value),
            strtolower($this->getId()),
            $this->args
        );
    }
}
