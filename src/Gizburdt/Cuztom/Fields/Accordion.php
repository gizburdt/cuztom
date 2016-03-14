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
    protected $_view = 'accordion';

    /**
     * Tabs type.
     * @var string
     */
    protected $_tabs_type = 'accordion';
}
