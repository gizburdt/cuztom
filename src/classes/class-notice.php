<?php

if( ! defined('ABSPATH') ) exit;

class Cuztom_Notice
{
    /**
     * Notice itself
     * @var string
     */
    var $notice;

    /**
     * Notice type
     * @var string
     */
    var $type;

    /**
     * Dismissible?
     * @var boolean
     */
    var $dismissible;

    /**
     * Constructor
     *
     * @param string  $notice
     * @param string  $type
     * @param boolean $dismissible
     * @since 2.3
     */
    function __construct($notice, $type = 'updated', $dismissible)
    {
        $this->notice       = $notice;
        $this->type         = $type;
        $this->dismissible  = $dismissible;

        add_action('admin_notices', array(&$this, 'add_admin_notice'));
    }

    /**
     * Adds the admin notice
     *
     * @since 2.3
     */
    function add_admin_notice()
    {
        echo '<div class="' . $this->get_css_class() . '">';
            echo '<p>' . $this->notice . '</p>';
        echo '</div>';
    }

    /**
     * Returns the complete css class for the notice
     *
     * @return string
     * @since  2.3
     */
    function get_css_class()
    {
        return $this->type . ($this->dismissible ? ' is-dismissible' : '');
    }
}