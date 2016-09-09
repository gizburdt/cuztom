<?php

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Entities\PostType;
use Gizburdt\Cuztom\Entities\Sidebar;
use Gizburdt\Cuztom\Entities\Taxonomy;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

if (! function_exists('register_cuztom_post_type')) {
    /**
     * Register a Post Type.
     *
     * @param  string $name
     * @param  array  $args
     * @return object
     */
    function register_cuztom_post_type($name, $args = array())
    {
        return new PostType($name, $args);
    }
}

if (! function_exists('register_cuztom_taxonomy')) {
    /**
     * Registers a Taxonomy for a Post Type.
     *
     * @param  string|array $name
     * @param  string|array $post_type
     * @param  array        $args
     * @return object
     */
    function register_cuztom_taxonomy($name, $post_type, $args = array())
    {
        return new Taxonomy($name, $post_type, $args);
    }
}

if (! function_exists('register_cuztom_sidebar')) {
    /**
     * Register Cuztom sidebar.
     *
     * @param  array  $args
     * @return object
     */
    function register_cuztom_sidebar($args)
    {
        return new Sidebar($args);
    }
}
