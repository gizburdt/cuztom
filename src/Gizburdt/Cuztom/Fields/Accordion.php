<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Accordion extends Tabs
{
    /**
     * View name.
     * @var string
     */
    public $view = 'accordion';

    /**
     * Tabs type.
     * @var string
     */
    public $tabs_type = 'accordion';
}
