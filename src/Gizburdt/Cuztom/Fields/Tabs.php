<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tabs extends Field
{
    /**
     * View name.
     * @var string
     */
    protected $_view = 'tabs';

    /**
     * Tabs type.
     * @var string
     */
    protected $_tabs_type = 'tabs';

    /**
     * Tabs.
     * @var array
     */
    public $tabs = array();

    /**
     * Outputs a field row.
     *
     * @param string|array $value
     * @pram  string       $view
     * @since 0.2
     */
    public function output_row($value = null, $view = null)
    {
        $view = $view ? $view : $this->get_view();

        Cuztom::view('fields/row/'.$view, array(
            'tabs'  => $this,
            'value' => $value
        ));
    }

    /**
     * Output.
     *
     * @param  string|array $value
     * @return string
     * @since  3.0
     */
    public function output($value = null, $view = null)
    {
        $view = $view ? $view : $this->get_view();

        Cuztom::view('fields/'.$this->_view, array(
            'tabs'  => $this,
            'value' => $value,
            'type'  => $this->_tabs_type
        ));
    }

    /**
     * Save.
     *
     * @param int   $object
     * @param array $values
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
     * @param array        $data
     * @param string|array $value
     * @since  3.0
     */
    public function build($data, $value)
    {
        foreach ($data as $title => $field) {
            $args = array_merge(array('title' => $title, '_meta_type' => $this->_meta_type, '_object' => $this->_object));
            $tab  = new Tab($args);

            $tab->build($field['fields'], $value);
            $tab->set_tabs_type($this->_tabs_type);

            $this->tabs[$title] = $tab;
        }
    }
}
