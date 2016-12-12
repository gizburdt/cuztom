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
    public $view = 'tabs';

    /**
     * Tabs.
     * @var array
     */
    public $panels = array();

    /**
     * Data.
     * @var array
     */
    public $data = array();

    /**
     * Constructor.
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->data = $this->build($args);
    }

    /**
     * Outputs a field row.
     *
     * @param string|array $value
     * @since 0.2
     */
    public function outputRow($value = null)
    {
        return Cuztom::view('fields/row/'.$this->view, array(
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
    public function output($value = null)
    {
        return Cuztom::view('fields/'.$this->view, array(
            'tabs'  => $this,
            'value' => $value,
            'type'  => $this->type
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
        foreach ($this->data as $tab) {
            $tab->save($object, $values);
        }
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
     * Build.
     *
     * @param array        $data
     * @param string|array $value
     * @since  3.0
     */
    public function build($args)
    {
        foreach ($this->panels as $panel) {
            $tab = new Tab(
                array_merge($panel, array('parent' => $this)),
                $this->value
            );

            $tab->meta_type = $this->meta_type;
            $tab->object    = $this->object;
            $tab->tabs_type = $this->type;

            $data[$tab->id] = $tab;
        }

        return $data;
    }
}
