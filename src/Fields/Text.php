<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Text extends Field
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input--text';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-text';

    /**
     * Parse value for HTML special chars.
     *
     * @param  string $value
     * @return string
     * @since  2.8
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
     * @since  3.0
     */
    public function doHtmlspecialchars(&$value)
    {
        return htmlspecialchars($value);
    }
}
