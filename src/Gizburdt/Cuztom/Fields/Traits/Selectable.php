<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

trait Selectable
{
    /**
     * Show option none?
     *
     * @return string
     * @since  3.0
     */
    protected function maybe_show_option_none()
    {
        if(! Cuztom::is_empty($this->args['show_option_none'])) {
            return '<option value="0" '.(Cuztom::is_empty($value) ? 'selected="selected"' : '').'>'.$this->args['show_option_none'].'</option>';
        }
    }
}
