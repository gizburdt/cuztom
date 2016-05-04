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
     * Tabs type.
     * @var string
     */
    public $tabs_type = 'tabs';

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
    public function __construct($args, $values)
    {
        parent::__construct($args, $values);

        $this->data = $this->build($args, $values);
    }

    /**
     * Outputs a field row.
     *
     * @param string|array $value
     * @since 0.2
     */
    public function output_row($value = null)
    {
        Cuztom::view('fields/row/'.$this->view, array(
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
        Cuztom::view('fields/'.$this->view, array(
            'tabs'  => $this,
            'value' => $value,
            'type'  => $this->tabs_type
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
    public function build($args, $value)
    {
        foreach ($this->panels as $title => $panel) {
            $tab = new Tab($panel, $value);

            $tab->meta_type = $this->meta_type;
            $tab->object    = $this->object;
            $tab->tabs_type = $this->tabs_type;

            $data[$tab->id] = $tab;
        }

        return $data;
    }
}
