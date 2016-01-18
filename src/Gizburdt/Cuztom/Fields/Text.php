<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Text extends Field
{
    /**
     * Feature support
     */
    public $_supports_repeatable    = true;
    public $_supports_bundle        = true;
    public $_supports_ajax            = true;

    /**
     * Attributes
     */
    public $css_classes            = array( 'cuztom-input', 'cuztom-input-text' );

    /**
     * Parse value
     *
     * @param 	string 		$value
     *
     * @author  Gijs Jorissen
     * @since 	2.8
     *
     */
    public function parse_value($value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, array( &$this, 'do_htmlspecialchars' ));
        } else {
            $value = htmlspecialchars($value);
        }

        return $value;
    }

    /**
     * Applies htmlspecialchars to $value
     *
     * @param 	string 		$value
     *
     * @author  Gijs Jorissen
     * @since 	3.0
     *
     */
    public function do_htmlspecialchars(&$value)
    {
        $value = htmlspecialchars($value);
    }
}
