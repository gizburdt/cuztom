<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tab extends Field
{
    /**
     * Tabs type.
     * @var string
     */
    public $tabs_type;

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
      * @param array $values
      * @since 3.0
      */
     public function __construct($args, $values = null)
     {
         parent::__construct($args, $values);

         if (! $this->id) {
             $this->id = Cuztom::uglify($this->title);
         }

         $this->data  = $this->build($args, $values);
     }

    /**
     * Output.
     *
     * @param  array  $args
     * @return string
     * @since  3.0
     */
    public function output_tab()
    {
        return Cuztom::view('fields/tab', array(
            'tab'   => $this,
            'type'  => $this->tabs_type
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
        foreach ($this->data as $field) {
            $field->save($object, $values);
        }
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
     * Build.
     *
     * @param  array        $data
     * @param  string|array $value
     * @return void
     * @since  3.0
     */
    public function build($args)
    {
        foreach ($this->fields as $field) {
            $field            = Field::create($field, $this->value);
            $field->meta_type = $this->meta_type;
            $field->object    = $this->object;

            $data[$field->id] = $field;
        }

        return $data;
    }
}
