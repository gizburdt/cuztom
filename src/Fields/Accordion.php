<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Guard;

Guard::blockDirectAccess();

class Accordion extends Tabs
{
    /**
     * Base.
     *
     * @var mixed
     */
    public $view = 'accordion';
}
