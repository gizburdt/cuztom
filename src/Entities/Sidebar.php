<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Sidebar
{
    /**
     * Constructor.
     *
     * @param  array  $args
     */
    public function __construct($args = [])
    {
        register_sidebar($args);
    }
}
