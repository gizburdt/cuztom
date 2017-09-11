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
     * @param  array        $args
     * @param  string|array $postType
     * @return object
     */
    function register_cuztom_meta_box($id, $postTypes, $args = array())
    {
        return new MetaBox($id, $postTypes, $args);
    }
}

if (! function_exists('register_cuztom_term_meta')) {
    /**
     * Register term meta fields.
     *
     * @param  string       $id
     * @param  array        $args
     * @param  string       $taxonomy
     * @param  array|string $locations
     * @return object
     */
    function register_cuztom_term_meta($id, $taxonomy, $args = array(), $locations = array('edit_form'))
    {
        return new TermMeta($id, $taxonomy, $args, $locations);
    }
}

if (! function_exists('register_cuztom_user_meta')) {
    /**
     * Register term meta fields.
     *
     * @param  string       $id
     * @param  array        $args
     * @param  array|string $locations
     * @return object
     */
    function register_cuztom_user_meta($id, $args = array(), $locations = array('show_user_profile', 'edit_user_profile'))
    {
        return new UserMeta($id, $args, $locations);
    }
}
