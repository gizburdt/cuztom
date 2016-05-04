<?php

namespace Gizburdt\Cuztom\Fields\Bundle;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Item extends Field
{
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
    public function __construct($args, $values)
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
    public function output_item($value = null, $index = 0)
    {
        Cuztom::view('fields/bundle/item', array(
            'item'  => $this,
            'index' => $index
        ));
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array      $args
     * @param array|null $values
     * @since 3.0
     */
    public function build($args, $values = null)
    {
        foreach ($this->fields as $type => $field) {
            $field            = Field::create($field, $values);
            $field->meta_type = $this->meta_type;
            $field->object    = $this->object;
            $field->value     = @$values[$field->id][0];

            $data[$field->id] = $field;
        }

        return $data;
    }
}
