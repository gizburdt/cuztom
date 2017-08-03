<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Guard
{
    /**
     * Block direct access.
     *
     * @return void
     */
    public static function directAccess()
    {
        if (! defined('ABSPATH')) {
            die();
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

    /**
     * Check nonce.
     *
     * @param  string $name
     * @param  string $value
     * @return bool
     */
    public static function verifyNonce($name, $value)
    {
        return isset($_POST[$name]) && wp_verify_nonce($_POST[$name], $value);
    }

    /**
     * Check AJAX nonce.
     *
     * @param  string $action
     * @param  string $arg
     * @return bool
     */
    public static function verifyAjaxNonce($action, $arg)
    {
        return check_ajax_referer($action, $arg);
    }

    /**
     * Check if given id (post) is of certain type(s).
     *
     * @param  int   $id
     * @param  array $postTypes
     * @return bool
     */
    public static function isPostType($id, $postTypes)
    {
        return in_array(get_post_type($id), array_merge($postTypes, array('revision')));
    }

    /**
     * Check if user can edit post.
     *
     * @param  int  $id
     * @return bool
     */
    public static function userCanEdit($id)
    {
        return current_user_can(get_post_type_object(get_post_type($id))->cap->edit_post, $id);
    }
}
