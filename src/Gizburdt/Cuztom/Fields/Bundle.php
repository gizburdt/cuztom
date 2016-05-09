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
     * Constructor.
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->data = $this->build($args);
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
        return Cuztom::view('fields/bundle/row', array(
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
        if (is_array($this->data)) {
            foreach ($this->data as $item) {
                @$ob .= $item->output();
            }
        }

        return $ob;
    }

    /**
     * Output a control row for a bundle.
     *
     * @param string $class
     * @since 3.0
     */
    public function output_control($class = 'top')
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
     * @since 1.6.2
     */
    public function save($object, $values)
    {
        $values = $values[$this->id];
        $values = is_array($values) ? array_values($values) : array();

        foreach ($values as $row => $fields) {
            foreach ($fields as $id => $value) {
                $values[$row][$id] = $this->data[0]->data[$id]->parse_value($value);
            }
        }

        parent::save($object, array($this->id => $values));
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array $data
     * @param array $values
     * @since 3.0
     */
    public function build($args)
    {
        // Build with value
        if (is_array($this->value)) {
            $i = 0;

            foreach ($this->value as $value) {
                $item = new BundleItem(
                    array_merge($args, array('parent' => $this, 'index' => $i)),
                    @$this->value[$i]
                );

                $i++;
            }
        }

        // Without value
        else {
            $item = new BundleItem(
                array_merge($args, array('parent' => $this))
            );
        }

        // Base
        $item->meta_type = $this->meta_type;
        $item->object    = $this->object;

        $data[] = $item;

        return @$data;
    }
}
