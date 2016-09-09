<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

abstract class Entity
{
    /**
     * Name.
     * @var string|array
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
     * Entity construct.
     *
     * @param string       $name
     * @param string|array $args
     * @since 3.0
     */
    public function __construct($name, $args)
    {
        $this->name     = $name;
        $this->original = $args;

        // Labels
        $this->title  = Cuztom::beautify($name);
        $this->plural = Cuztom::pluralize($this->title);
    }
}
