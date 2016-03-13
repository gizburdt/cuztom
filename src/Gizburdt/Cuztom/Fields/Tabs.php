<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tabs extends Field
{
    /**
     * Tabs.
     * @var array
     */
    public $tabs = array();

    /**
     * Output row.
     *
     * @param  string|array $value
     * @return string
     * @since  3.0
     */
    public function output_row($value = null)
    {
        Cuztom::view('fields/row/tabs', array(
            'tabs'  => $this,
            'value' => $value
        ));
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
        $args['type'] = 'tabs';

        Cuztom::view('fields/tabs', array(
            'field' => $this,
            'value' => $value,
            'args'  => $args
        ));
    }

    /**
     * Save.
     *
     * @param  int   $object
     * @param  array $values
     * @return void
     * @since  3.0
     */
    public function save($object, $values)
    {
        foreach ($this->tabs as $tab) {
            $tab->save($object, $values);
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
        foreach ($data as $title => $field) {
            $args = array_merge(array('title' => $title, 'meta_type' => $this->meta_type, 'object' => $this->object));
            $tab  = new Tab($args);

            $tab->build($field['fields'], $value);

            $this->tabs[$title] = $tab;
        }
    }
}
