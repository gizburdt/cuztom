<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Guard
{
    /**
     * Block direct access
     *
     * @return void
     * @since  3.0
     */
    public static function directAccess()
    {
        if (! defined('ABSPATH')) {
            exit;
        }
    }

    /**
     * Check autosave
     *
     * @return boolean
     */
    public static function doingAutosave()
    {
        return defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
    }

    /**
     * Check ajax
     *
     * @return boolean
     */
    public static function doingAjax()
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }

    /**
     * Check nonce.
     *
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public static function verifyNonce($name, $value)
    {
        return isset($_POST[$name]) && wp_verify_nonce($_POST[$name], $value);
    }
}
