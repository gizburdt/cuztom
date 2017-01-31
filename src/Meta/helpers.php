<?php

use Gizburdt\Cuztom\Meta\Box as MetaBox;
use Gizburdt\Cuztom\Meta\Term as TermMeta;
use Gizburdt\Cuztom\Meta\User as UserMeta;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

if (! function_exists('register_cuztom_meta_box')) {
    /**
     * Register met box.
     *
     * @param  string       $id
     * @param  array        $data
     * @param  string|array $postType
     * @return object
     */
    function register_cuztom_meta_box($id, $postType, $data = array())
    {
        return new MetaBox($id, $postType, $data);
    }
}

if (! function_exists('register_cuztom_term_meta')) {
    /**
     * Register term meta fields.
     *
     * @param  string       $id
     * @param  array        $data
     * @param  string       $taxonomy
     * @param  array|string $locations
     * @return object
     */
    function register_cuztom_term_meta($id, $taxonomy, $data = array(), $locations = array('edit_form'))
    {
        return new TermMeta($id, $taxonomy, $data, $locations);
    }
}

if (! function_exists('register_cuztom_user_meta')) {
    /**
     * Register term meta fields.
     *
     * @param  string       $id
     * @param  array        $data
     * @param  string       $taxonomy
     * @param  array|string $locations
     * @return object
     */
    function register_cuztom_user_meta($id, $data = array(), $locations = array('show_user_profile', 'edit_user_profile'))
    {
        return new UserMeta($id, $data, $locations);
    }
}
