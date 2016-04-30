<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Bundle extends Field
{
    /**
     * Bundle items.
     * @var array
     */
    public $bundles = array();

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
     * Output a row.
     *
     * @param mixed  $value
     * @param string $view
     * @since 3.0
     */
    public function output_row($value = null, $view = null)
    {
        Cuztom::view('fields/bundle/row', array(
            'bundle' => $this,
            'value'  => $value
        ));
    }

    /**
     * Outputs a bundle.
     *
     * @param mixed  $value
     * @param string $view
     * @since 1.6.5
     */
    public function output($value = null, $view = null)
    {
        $i     = 0;
        $value = (! is_null($value)) ? $value : $this->value;

        foreach ($this->bundles as $item) {
            $item->output_item($i);
            $i++;
        }
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

        // Foreach for correct array
        foreach ($values as $row => $fields) {
            foreach ($fields as $id => $value) {
                $values[$row][$id] = $this->fields[$id]->parse_value($value);
            }
        }

        parent::save($object, array($this->id => $values));
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array      $data
     * @param array|null $values
     * @since 3.0
     */
    public function build($args, $values = null)
    {
        // Build fields
        if (is_array($this->value)) {
            foreach ($this->value as $id => $value) {
                $data[] = new BundleItem($args, $values);
            }
        }

        return @$data;
    }
}
