<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Text extends Field
{
    /**
     * Css class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-input-text';

    /**
     * Parse value
     *
     * @param  string $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, array(&$this, 'do_htmlspecialchars'));
        } else {
            $value = $this->do_htmlspecialchars($value);
        }

        return $value;
    }

    /**
     * Applies htmlspecialchars to $value
     *
     * @param  string &$value
     * @return string
     * @since  3.0
     */
    public function do_htmlspecialchars(&$value)
    {
        $value = htmlspecialchars($value);
    }
}
