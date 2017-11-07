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

        if (! empty($labels)) {
            if (is_string($labels)) {
                $this->title = $labels;
            } else if (is_array($labels)) {
                $size = count($labels);
                if ($size > 0) {
                    $this->title = $labels[0];
                }
                if ($size > 1) {
                   $this->plural = $labels[1];
                }
            }
        }

        if (empty($this->title)) {
            $this->title = Cuztom::beautify($name);
        }
        if (empty($this->plural)) {
            $this->plural = Cuztom::pluralize($this->title);
        }

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
