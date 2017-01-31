<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Text extends Field
{
    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--text';
    public $cell_css_class = 'cuztom-field--text';

    /**
     * Parse value for HTML special chars.
     *
     * @param  string $value
     * @return string
     */
    public function parseValue($value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, array(&$this, 'doHtmlspecialchars'));
        } else {
            $value = $this->doHtmlspecialchars($value);
        }

        return parent::parseValue($value);
    }

    /**
     * Applies htmlspecialchars to $value.
     *
     * @param  string &$value
     * @return string
     */
    public function doHtmlspecialchars(&$value)
    {
        return htmlspecialchars($value);
    }
}
