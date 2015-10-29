<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers sidebars
 *
 * @author  Gijs Jorissen
 * @since   0.5
 *
 */
class Cuztom_Sidebar
{
    var $sidebar;

    /**
     * Constructor
     * @param array $args
     * @since 0.5
     */
    function __construct( $args = array() )
    {
        $this->sidebar = array(
            'name'              => @$args['name'],
            'id'                => @$args['id'],
            'description'       => @$args['description'],
            'class'             => @$args['class'],
            'before_widget'     => @$args['before_widget'],
            'after_widget'      => @$args['after_widget'],
            'before_title'      => @$args['before_title'],
            'after_title'       => @$args['after_title'],
        );

        add_action( 'widgets_init', array( &$this, 'register_sidebar' ) );
    }

    /**
     * Register the sidebar
     * @since 0.1
     */
    function register_sidebar()
    {
        register_sidebar( $this->sidebar );
    }
}