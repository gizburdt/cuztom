<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Guard;
use Gizburdt\Cuztom\Cuztom;

Guard::blockDirectAccess();

trait Selectable
{
    /**
     * Show option none?
     *
     * @return string
     */
    public function maybeShowOptionNone()
    {
        if (isset($this->args['show_option_none']) && ! Cuztom::isEmpty($this->args['show_option_none'])) {
            return '<option value="-1" '.(Cuztom::isEmpty($this->value) ? 'selected="selected"' : '').'>'.$this->args['show_option_none'].'</option>';
        }
    }
}
