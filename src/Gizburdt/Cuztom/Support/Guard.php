<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Guard
{
    /**
     * Block direct access
     * @return void
     * @since  3.0
     */
    public static function directAccess()
    {
        if (! defined('ABSPATH')) {
            exit;
        }
    }
}
