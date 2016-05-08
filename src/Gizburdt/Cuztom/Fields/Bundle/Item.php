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
     * Fields.
     * @var array
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
     * @since  3.0
     */
    public function output($value = null)
    {
        Cuztom::view('fields/bundle/item', array(
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
    public function substract_value($values)
    {
        return $values;
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array      $args
     * @param array|null $values
     * @since 3.0
     */
    public function build($args)
    {
        foreach ($this->fields as $field) {
            $field            = Field::create($field, $this->value);
            $field->meta_type = $this->meta_type;
            $field->object    = $this->object;

            // Change name
            $field->before_name = '['.$this->parent->id.']['.$this->index.']';
            $field->before_id   = $this->parent->id.'_'.$this->index;

            $data[$field->id] = $field;
        }

        return $data;
    }
}
