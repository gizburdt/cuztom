<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Sidebar
{
    /**
     * Sidebar
     *
     * @var array
     */
    var $sidebar;

    /**
     * Constructor
     *
     * @param array $args
     * @since 0.5
     */
    function __construct($args = array())
    {
        $this->sidebar = array(
            'name'          => @$args['name'],
            'id'            => @$args['id'],
            'description'   => @$args['description'],
            'class'         => @$args['class'],
            'before_widget' => @$args['before_widget'],
            'after_widget'  => @$args['after_widget'],
            'before_title'  => @$args['before_title'],
            'after_title'   => @$args['after_title'],
        );

        // Register
        register_sidebar($this->sidebar);
    }
}