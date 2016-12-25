<?php

namespace Gizburdt\Cuztom\Fields\Bundle;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Item extends Field
{
    /**
     * Bundle (parent).
     * @var object
     */
    public $parent;

    /**
     * Index.
     * @var int
     */
    public $index = 0;

    /**
     * Fillables.
     * @var mixed
     */
    public $fields = array();

    /**
     * Constructor.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->data = $this->build($args, $values);
    }

    /**
     * Outputs bundle item.
     *
     * @param  int    $index
     * @return string
     */
    public function output($value = null)
    {
        return Cuztom::view('fields/bundle/item', array(
            'item'  => $this,
            'index' => $this->index
        ));
    }

    /**
     * Substract value.
     *
     * @param  array        $values
     * @return string|array
     */
    public function substractValue($values)
    {
        return $values;
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array      $args
     * @param array|null $values
     */
    public function build($args)
    {
        foreach ($this->fields as $field) {
            $field           = Field::create($field, $this->value);
            $field->metaType = $this->metaType;
            $field->object   = $this->object;

            // Change name
            $field->beforeName = '['.$this->parent->id.']['.$this->index.']';
            $field->beforeId   = $this->parent->id.'_'.$this->index;

            $data[$field->id] = $field;
        }

        return $data;
    }
}
