<?php

if( ! defined('ABSPATH') ) exit;

if( ! function_exists('register_cuztom_user_meta') ) {
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
        return new Cuztom_User_Meta( $id, $data, $locations );
    }
}