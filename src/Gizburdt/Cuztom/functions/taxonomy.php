<?php

if (! defined('ABSPATH')) {
    exit;
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
        return new Cuztom_Taxonomy($name, $post_type, $args, $labels);
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
        return new Cuztom_Term_Meta($id, $taxonomy, $data = array(), $locations);
    }
}
