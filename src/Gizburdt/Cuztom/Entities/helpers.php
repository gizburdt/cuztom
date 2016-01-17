<?php

use Gizburdt\Cuztom\Entities\PostType;
use Gizburdt\Cuztom\Entities\Taxonomy;
use Gizburdt\Cuztom\Entities\Sidebar;
use Gizburdt\Cuztom\Meta\Box as MetaBox;
use Gizburdt\Cuztom\Meta\Term as TermMeta;
use Gizburdt\Cuztom\Meta\User as UserMeta;

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('register_cuztom_post_type')) {
    /**
     * Register a Post Type
     *
     * @param  string $name
     * @param  array  $args
     * @param  array  $labels
     * @return object
     */
    function register_cuztom_post_type($name, $args = array(), $labels = array())
    {
        return new PostType($name, $args, $labels);
    }
}

if (! function_exists('register_cuztom_meta_box')) {
    /**
     * Register met box
     *
     * @param  string       $id
     * @param  array        $data
     * @param  string|array $post_type
     * @return object
     */
    function register_cuztom_meta_box($id, $post_type, $data = array())
    {
        return new MetaBox($id, $post_type, $data);
    }
}

if (! function_exists('register_cuztom_taxonomy')) {
    /**
     * Registers a Taxonomy for a Post Type
     *
     * @param  string|array $name
     * @param  string|array $post_type
     * @param  array        $args
     * @param  array        $labels
     * @return object
     */
    function register_cuztom_taxonomy($name, $post_type, $args = array(), $labels = array())
    {
        return new Taxonomy($name, $post_type, $args, $labels);
    }
}

if (! function_exists('register_cuztom_term_meta')) {
    /**
    * Register term meta fields
    *
    * @param  string        $id
    * @param  array         $data
    * @param  string        $taxonomy
    * @param  array|string  $locations
    * @return object
    */
    function register_cuztom_term_meta($id, $taxonomy, $data = array(), $locations = array('add_form', 'edit_form'))
    {
        return new TermMeta($id, $taxonomy, $data = array(), $locations);
    }
}

if (! function_exists('register_cuztom_sidebar')) {
    /**
     * Register Cuztom sidebar
     *
     * @param  array $args
     * @return object
     */
    function register_cuztom_sidebar($args)
    {
        return new Sidebar($args);
    }
}

if (! function_exists('register_cuztom_user_meta')) {
    /**
    * Register term meta fields
    *
    * @param  string        $id
    * @param  array         $data
    * @param  string        $taxonomy
    * @param  array|string  $locations
    * @return object
    */
    function register_cuztom_user_meta($id, $data = array(), $locations = array('show_user_profile', 'edit_user_profile'))
    {
        return new UserMeta($id, $data, $locations);
    }
}