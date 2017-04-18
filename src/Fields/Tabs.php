<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tabs extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $view = 'tabs';

    /**
     * Fillables.
     * @var mixed
     */
    public $panels = array();

    /**
     * Data.
     * @var array
     */
    public $data = array();

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->data = $this->build($args);

        // Do
        do_action('cuztom_tabs_init', $this);
    }

    /**
     * Outputs a field cell.
     *
     * @param string|array $value
     */
    public function outputCell($value = null)
    {
        return Cuztom::view('fields/cell/'.$this->view, array(
            'tabs'  => $this,
            'value' => $value
        ));
    }

    /**
     * Output.
     *
     * @param  string|array $value
     * @return string
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
     */
    public function save($object, $values)
    {
        do_action('cuztom_tabs_save', $this);

        foreach ($this->data as $tab) {
            $tab->save($object, apply_filters('cuztom_tabs_save_values', $values, $this));
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
     * Get field.
     *
     * @param  string $search
     * @return mixed
     */
    public function getField($search)
    {
        foreach ($this->data as $field) {
            if ($find = $field->getField($search)) {
                break;
            }
        }

        return $find;
    }

    /**
     * Build.
     *
     * @param array        $data
     * @param string|array $value
     */
    public function build($args)
    {
        foreach ($this->panels as $panel) {
            $args = Cuztom::merge($panel, array(
                'parent'   => $this,
                'metaBox'  => $this->metaBox,
                'metaType' => $this->metaType,
                'object'   => $this->object,
                'tabsType' => $this->type,
            ));

            $tab = new Tab($args, $this->value);

            $data[$tab->id] = $tab;
        }

        return @$data;
    }
}
