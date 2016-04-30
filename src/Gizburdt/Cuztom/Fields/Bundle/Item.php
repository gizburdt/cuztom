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

        return ob_get_clean();
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array      $data
     * @param array|null $values
     * @since 3.0
     */
    public function build($data, $values = null)
    {
        // foreach($data as $type => $field) {
        //     if (is_string($type) && $type == 'tabs') {
        //         // $tab->fields = $this->build( $fields );
        //     } else {
        //         $field['_meta_type'] = $this->_meta_type;
        //         $field['_object']    = $this->_object;
        //         $field['_value']     = $this->_value[$field['id']];
        //
        //         $field                = Field::create($field);
        //         $field->repeatable    = false;
        //         $field->ajax          = false;
        //         // $field->before_name   = '['.$bundle->get_id().']['.$index.']';
        //         $field->after_id      = '_'.$index;
        //
        //         $this->fields[$field->id] = $field;
        //     }
        // }

        return $this;
    }
}
