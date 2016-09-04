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
     * @param string|array $name
     * @since 3.0
     */
    public function __construct($name)
    {
        if (is_array($name)) {
            $this->name   = Cuztom::uglify($name[0]);
            $this->title  = Cuztom::beautify($name[0]);
            $this->plural = Cuztom::beautify($name[1]);
        } else {
            $this->name   = Cuztom::uglify($name);
            $this->title  = Cuztom::beautify($name);
            $this->plural = Cuztom::pluralize(Cuztom::beautify($name));
        }
    }
}
