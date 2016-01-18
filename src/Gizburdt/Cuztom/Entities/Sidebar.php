<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Entities\Entity;

Guard::directAccess();

class Sidebar
{
    /**
     * Sidebar
     *
     * @var array
     */
    public $sidebar;

    /**
     * Constructor
     *
     * @param array $args
     * @since 0.5
     */
    public function __construct($args = array())
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
