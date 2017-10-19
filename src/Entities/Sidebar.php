<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Guard;

Guard::blockDirectAccess();

class Sidebar
{
    /**
     * Constructor.
     *
     * @param array $args
     */
    public function __construct($args = array())
    {
        register_sidebar($args);
    }
}
