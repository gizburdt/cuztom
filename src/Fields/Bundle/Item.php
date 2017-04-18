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

        // Do
        do_action('cuztom_bundle_item_init', $this);
    }

    /**
     * Outputs bundle item.
     *
     * @param  int    $index
     * @return string
     */
    public function output($value = null)
    {
        return Cuztom::view('fields/bundle/table', array(
            'item' => $this,
        ));
    }

    /**
     * Return field from data.
     *
     * @param  string $field
     * @return object
     */
    public function getField($field)
    {
        return isset($this->data[$field]) ? $this->data[$field] : null;
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
            $args = Cuztom::merge($field, array(
                'metaType'   => $this->metaType,
                'object'     => $this->object,
                'beforeName' => '['.$this->parent->id.']['.$this->index.']',
                'beforeId'   => $this->parent->id.'_'.$this->index,
            ));

            $field = Field::create($args, $this->value);

            $data[$field->id] = $field;
        }

        return $data;
    }
}
