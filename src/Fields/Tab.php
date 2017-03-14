<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tab extends Field
{
    /**
     * Tabs type.
     * @var string
     */
    public $tabsType;

    /**
     * Fillables.
     * @var mixed
     */
    public $title;
    public $fields = array();

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        if (! $this->id) {
            $this->id = Cuztom::uglify($this->title);
        }

        $this->data  = $this->build($args, $values);
    }

    /**
     * Output.
     *
     * @param  array  $args
     * @return string
     */
    public function outputTab()
    {
        return Cuztom::view('fields/tab', array(
            'tab'   => $this,
            'type'  => $this->tabsType
        ));
    }

    /**
     * Save.
     *
     * @param  int          $object
     * @param  string|array $values
     * @return string
     */
    public function save($object, $values)
    {
        foreach ($this->data as $field) {
            $field->save($object, $values);
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
        return isset($this->data[$search])
            ? $this->data[$search]
            : null;
    }

    /**
     * Build.
     *
     * @param  array        $data
     * @param  string|array $value
     * @return void
     */
    public function build($args)
    {
        foreach ($this->fields as $field) {
            $args = Cuztom::merge($field, array(
                'metaBox'  => $this->metaBox,
                'metaType' => $this->metaType,
                'object'   => $this->object,
            ));

            $field = Field::create($args, $this->value);

            $data[$field->id] = $field;
        }

        return $data;
    }
}
