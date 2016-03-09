<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Guard
{
    /**
     * Block direct access.
     *
     * @return void
     *
     * @since  3.0
     */
    public static function directAccess()
    {
        if (!defined('ABSPATH')) {
            exit;
        }
    }

    /**
     * Check autosave.
     *
     * @return bool
     */
    public static function doingAutosave()
    {
        return defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
    }

    /**
     * Check ajax.
     *
     * @return bool
     */
    public static function doingAjax()
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }
}
