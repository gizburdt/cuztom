<?php

if (! defined('ABSPATH')) {
    exit;
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
        return new Cuztom_Sidebar($args);
    }
}
