<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

trait Selectable
{
    /**
     * Show option none?
     *
     * @return string
     * @since  3.0
     */
    public function maybe_show_option_none()
    {
        if (! Cuztom::is_empty($this->args['show_option_none'])) {
            return '<option value="-1" '.(Cuztom::is_empty($value) ? 'selected="selected"' : '').'>'.$this->args['show_option_none'].'</option>';
        }
    }
}
