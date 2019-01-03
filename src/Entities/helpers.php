<?php

use Gizburdt\Cuztom\Entities\Sidebar;
use Gizburdt\Cuztom\Entities\PostType;
use Gizburdt\Cuztom\Entities\Taxonomy;
use Gizburdt\Cuztom\Guard;

Guard::blockDirectAccess();

if (! function_exists('register_cuztom_post_type')) {
    /**
     * Register a Post Type.
     *
     * @param  string $name
     * @param  array  $args
     * @return object
     */
    function register_cuztom_post_type($name, $args = [])
    {
        return new PostType($name, $args);
    }
}

if (! function_exists('register_cuztom_taxonomy')) {
    /**
     * Registers a Taxonomy for a Post Type.
     *
     * @param  string       $name
     * @param  string|array $postType
     * @param  array        $args
     * @return object
     */
    function register_cuztom_taxonomy($name, $post_type, $args = [])
    {
        return new Taxonomy($name, $postTypes, $args);
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
