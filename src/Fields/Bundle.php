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
        return Cuztom::view('fields/bundle/bundle', array(
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
        return Cuztom::view('fields/bundle/item');
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
        $values = isset($values[$this->id])
            ? $values[$this->id]
            : null;

        $values[$this->id] = is_array($values)
            ? array_values($values)
            : array();

        foreach ($values as $cell => $fields) {
            foreach ($fields as $id => $value) {
                $values[$this->id][$cell][$id] = $this->getFirstItem()->getField($id)->parseValue($value);
            }
        }

        parent::save($object, $values);
    }

    /**
     * Get first bundle item.
     *
     * @return object
     */
    public function getFirstItem()
    {
        return isset($this->data[0]) ? $this->data[0] : null;
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

        // Set arguments
        $args = Cuztom::merge($args, array(
            'parent'   => $this,
            'index'    => $i,
            'metaType' => $this->metaType,
            'object'   => $this->object,
        ));

        // Build with value
        if (Cuztom::isArray($this->value)) {
            foreach ($this->value as $value) {
                $data[] = new BundleItem($args, @$this->value[$i]);

                $i++;
            }
        }

        // Without value
        else {
            $data[] = new BundleItem($args);
        }

        return @$data;
    }
}
