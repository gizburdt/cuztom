<?php

if( ! defined('ABSPATH') ) exit;

class Cuztom_Entity
{
    var $name;
    var $title;
    var $plural;

    /**
     * Entity construct
     *
     * @param string|array $name
     * @since 3.0
     */
    function __construct($name)
    {
        if( is_array($name) ) {
            $this->name     = Cuztom::uglify($name[0]);
            $this->title    = Cuztom::beautify($name[0]);
            $this->plural   = Cuztom::beautify($name[1]);
        } else {
            $this->name     = Cuztom::uglify($name);
            $this->title    = Cuztom::beautify($name);
            $this->plural   = Cuztom::pluralize(Cuztom::beautify($name));
        }
    }
}