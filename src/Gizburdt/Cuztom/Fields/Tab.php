<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tab extends Field
{
    /**
     * Title.
     * @var string
     */
    public $title;

    /**
     * Fields.
     * @var array
     */
    public $fields = array();

    /**
     * Construct.
     *
     * @param array $args
     * @since 3.0
     */
    public function __construct($args)
    {
        parent::__construct($args);

        if (! $this->id) {
            $this->id = Cuztom::uglify($this->title);
        }
    }

    /**
     * Output.
     *
     * @param  array  $args
     * @return string
     * @since  3.0
     */
    public function output($args = array())
    {
        Cuztom::view('fields/tab', array(
            'tab'   => $this,
            'args'  => $args
        ));
    }

    /**
     * Save.
     *
     * @param  int          $object
     * @param  string|array $values
     * @return string
     * @since  3.0
     */
    public function save($object, $values)
    {
        foreach ($this->fields as $id => $field) {
            $field->save($object, $values);
        }
    }

    /**
     * Build.
     *
     * @param  array        $data
     * @param  string|array $value
     * @return void
     * @since  3.0
     */
    public function build($data, $value)
    {
        foreach ($data as $type => $field) {
            if (is_string($type) && $type == 'bundle') {
                // $tab->fields = $this->build( $fields );
            } else {
                $args  = array_merge($field, array('meta_type' => $this->meta_type, 'object' => $this->object, 'value' => @$value[$field['id']][0]));
                $field = Field::create($args);

                $this->fields[$field->id] = $field;
            }
        }
    }
}
