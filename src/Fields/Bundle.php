<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Bundle extends Field
{
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
    }

    /**
     * Output field cell.
     *
     * @param mixed  $value
     * @param string $view
     */
    public function outputCell($value = null, $view = null)
    {
        return Cuztom::view('fields/cell/bundle', array(
            'bundle' => $this,
            'value'  => $value
        ));
    }

    /**
     * Outputs a bundle.
     *
     * @param mixed  $value
     * @param string $view
     */
    public function output($value = null, $view = null)
    {
        if (is_array($this->data)) {
            foreach ($this->data as $item) {
                @$output .= $item->output();
            }
        }

        return @$output;
    }

    /**
     * Output a control cell for a bundle.
     *
     * @param string $class
     */
    public function outputControl($class = 'top')
    {
        return Cuztom::view('fields/bundle/control', array(
            'bundle' => $this,
            'class'  => $class
        ));
    }

    /**
     * Save bundle meta.
     *
     * @param int   $object
     * @param array $values
     */
    public function save($object, $values)
    {
        $values = $values[$this->id];
        $values = is_array($values) ? array_values($values) : array();

        foreach ($values as $cell => $fields) {
            foreach ($fields as $id => $value) {
                $values[$cell][$id] = $this->data[0]->data[$id]->parseValue($value);
            }
        }

        parent::save($object, array($this->id => $values));
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array $data
     * @param array $values
     */
    public function build($args)
    {
        $i = 0;

        // Build with value
        if (is_array($this->value)) {
            foreach ($this->value as $value) {
                $item = new BundleItem(
                    array_merge($args, array('parent' => $this, 'index' => $i)),
                    @$this->value[$i]
                );

                $item->metaType = $this->metaType;
                $item->object   = $this->object;

                $data[] = $item;

                $i++;
            }
        }

        // Without value
        else {
            $item = new BundleItem(
                array_merge($args, array('parent' => $this))
            );

            $item->metaType = $this->metaType;
            $item->object   = $this->object;

            $data[] = $item;
        }

        return @$data;
    }
}
