<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Notice;

Guard::directAccess();

abstract class Entity
{
    /**
     * Original.
     * @var array
     */
    public $original;

    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Title.
     * @var string
     */
    public $title;

    /**
     * Plural.
     * @var string
     */
    public $plural;

    /**
     * Labels.
     * @var array
     */
    public $labels;

    /**
     * Entity construct.
     *
     * @param string       $name
     * @param string|array $args
     * @param string|array $labels
     */
    public function __construct($name, $args, $labels = array())
    {
        $this->name     = $name;
        $this->original = $args;

        if(!empty($labels)) {
            if (is_string($labels)) {
                # code...
            }
        }


        $this->title = Cuztom::beautify($name);
        $this->plural = Cuztom::pluralize($this->title);



        // Labels
        if (empty($labels) || (!is_array($labels) && !is_string($labels))){
            $labels = array();
        }

        if( !is_array($labels) && is_string($labels)){
            $labels = array($labels);
        }
        
        $this->title  =  count($labels) > 0 && is_string($labels[0]) ? $labels[0] : 
        

        // Do
        do_action('cuztom_entity_init');
    }

    /**
     * Register entity.
     *
     * @return void
     */
    public function registerEntity()
    {
        if ($reserved = Cuztom::isReservedTerm($this->name)) {
            return new Notice($reserved->get_error_message(), 'error');
        }
    }
}
