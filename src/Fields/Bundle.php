<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Guard;
use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;

Guard::blockDirectAccess();

class Bundle extends Field
{
    /**
     * Data.
     *
     * @var array
     */
    public $data = [];

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
        do_action('cuztom_bundle_init', $this);
    }

    /**
     * Output field cell.
     *
     * @param mixed  $value
     * @param string $view
     */
    public function outputCell($value = null, $view = null)
    {
        return Cuztom::view('fields/bundle/bundle', [
            'bundle' => $this,
            'value'  => $value,
        ]);
    }

    /**
     * Output a control cell for a bundle.
     *
     * @param string $class
     */
    public function outputControl($class = 'top')
    {
        return Cuztom::view('fields/bundle/control', [
            'bundle' => $this,
            'class'  => $class,
        ]);
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

        $values = is_array($values)
            ? array_values($values)
            : [];

        // Filter
        $values = apply_filters('cuztom_bundle_save_values', $values, $this);

        // Do
        do_action('cuztom_bundle_save', $this);

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
     * Get field.
     *
     * @param string $search
     *
     * @return mixed
     */
    public function getField($search)
    {
        return $this->getFirstItem()->data[$search];
    }

    /**
     * This method builds the complete array for a bundle.
     *
     * @param array $data
     * @param array $values
     */
    public function build($args)
    {
        $data = [];

        $args = array_merge($args, [
            'parent'   => $this,
            'metaType' => $this->metaType,
            'object'   => $this->object,
        ]);

        // Build with value
        if (is_array($this->value)) {
            $i = 0;

            foreach ($this->value as $value) {
                $args = array_merge($args, ['index' => $i]);

                $data[] = new BundleItem($args, $value);

                $i++;
            }
        }

        // Without value
        else {
            $args = array_merge($args, ['index' => 0]);

            $data[] = new BundleItem($args);
        }

        return $data;
    }
}
