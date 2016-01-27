<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Wysiwyg extends Field
{
    /**
     * Constructs Cuztom_Field_Wysiwyg
     *
     * @author 	Gijs Jorissen
     * @since 	0.3.3
     *
     */
    public function __construct($field)
    {
        parent::__construct($field);

        // Set necessary args
        @$this->args['editor_class'] .= ' cuztom-input';
        $this->args['textarea_name'] = 'cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name;
    }

    /**
     * Output method
     *
     * @return  string
     *
     * @author 	Gijs Jorissen
     * @since 	2.4
     *
     */
    public function _output_input($value = null)
    {
        return wp_editor((! empty($value) ? $value : $this->default_value), $this->before_id . $this->id . $this->after_id, $this->args);
    }
}
