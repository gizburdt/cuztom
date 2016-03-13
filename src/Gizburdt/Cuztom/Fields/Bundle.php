<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Bundle extends Field
{
    /**
     * Type.
     * @var string
     */
    public $type = 'bundle';

    /**
     * Fields
     * @var array
     */
    public $fields = array();

    /**
     * Output a row.
     *
     * @param mixed $value
     * @since 3.0
     */
    public function output_row($value = null)
    {
        Cuztom::view('fields/bundle/row', array(
            'bundle' => $this,
            'value'  => $value
        ));
    }

    /**
     * Outputs a bundle.
     *
     * @param mixed $value
     * @since 1.6.5
     */
    public function output($value = null)
    {
        $i = 0;

        if (! empty($this->value) && isset($this->value[0])) {
            foreach ($this->value as $bundle) {
                echo $this->output_item($i);
                $i++;
            }
        } elseif (! empty($this->default_value)) {
            foreach ($this->default_value as $default) {
                echo $this->output_item($i);
                $i++;
            }
        } else {
            echo $this->output_item();
        }
    }

    /**
     * Outputs bundle item.
     *
     * @param  int    $index
     * @return string
     * @since  3.0
     */
    public function output_item($index = 0)
    {
        Cuztom::view('fields/bundle/control', array(
            'bundle' => $this,
            'index'  => $index
        ));
    }

    /**
     * Output a control row for a bundle.
     *
     * @param string $class
     * @since 3.0
     */
    public function output_control($class = 'top')
    {
        Cuztom::view('fields/bundle/control', array(
            'bundle' => $this,
            'class'  => $class
        ));
    }

    /**
     * Save bundle meta.
     *
     * @param int   $object
     * @param array $values
     * @since 1.6.2
     */
    public function save($object, $values)
    {
        $values = $values[$this->id];
        $values = is_array($values) ? array_values($values) : array();

        foreach ($values as $row => $fields) {
            foreach ($fields as $id => $value) {
                $values[$row][$id] = $this->fields[$id]->parse_value($value);
            }
        }

        parent::save($object, $values);
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
        // Unset fields with array
        $this->fields = array();

        // Build fields with objects
        foreach ($data as $type => $field) {
            if (is_string($type) && $type == 'tabs') {
                // $tab->fields = $this->build( $fields );
            } else {
                $field['meta_type'] = $this->meta_type;
                $field['object']    = $this->object;

                $field             = Field::create($field);
                $field->repeatable = false;
                $field->ajax       = false;

                $this->fields[$field->id] = $field;
            }
        }
    }
}
