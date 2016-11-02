<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Sidebar
{
    /**
     * Sidebar.
     * @var array
     */
    public $sidebar;

    /**
     * Constructor.
     *
     * @param array $args
     * @since 0.5
     */
    public function __construct($args = array())
    {
        register_sidebar($args);
    }
}
