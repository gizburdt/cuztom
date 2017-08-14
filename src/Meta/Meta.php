<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

abstract class Meta
{
    /**
     * ID.
     * @var string
     */
    public $id;

    /**
     * Callback.
     * @var string
     */
    public $callback;

    /**
     * Title.
     * @var string
     */
    public $title;

    /**
     * Description.
     * @var string
     */
    public $description;

    /**
     * Fields.
     * @var array
     */
    public $fields;

    /**
     * Data.
     * @var array
     */
    public $data;

    /**
     * Object.
     * @var int
     */
    public $object;

    /**
     * Meta type.
     * @var string
     */
    public $metaType;

    /**
     * Get object id.
     *
     * @return int
     */
    abstract public function determineObject();

    /**
     * Get meta values.
     *
     * @return array
     */
    abstract public function getMetaValues();

    /**
     * Construct for all meta types, creates title (and description).
     *
     * @param string $id   ID
     * @param array  $data Array of data
     */
    public function __construct($id, $data)
    {
        // Set all properties
        foreach ($data as $property => $value) {
            $this->$property = isset($data[$property]) ? $data[$property] : $this->$property;
        }

        // Set hard
        $this->id     = $id;
        $this->object = $this->determineObject();
        $this->values = $this->getMetaValues();

        // Callback
        if (! $this->callback) {
            $this->callback = array($this, 'output');

            // Build the meta box and fields
            $this->data = $this->build($this->fields);

            // Assign global
            Cuztom::addBox($this);
        }

        // Do
        do_action('cuztom_meta_init', $this);
    }

    /**
     * Main callback for meta.
     *
     * @return void
     */
    public function output()
    {
        // Nonce field for validation
        wp_nonce_field('cuztom_meta', 'cuztom_nonce');

        echo Cuztom::view('meta/meta', array(
            'box' => $this
        ));
    }

    /**
     * Normal save method to save all the fields in a metabox.
     *
     * @param int   $object Object ID
     * @param array $values Array of values
     */
    public function save($object, $values)
    {
        if (Cuztom::isEmpty($values)) {
            return;
        }

        // Filter
        $values = apply_filters('cuztom_meta_values', $values, $this);

        // Do
        do_action('cuztom_meta_save', $this);

        foreach ($this->data as $id => $field) {
            $field->save($object, $values);
        }
    }

    /**
     * Get field.
     *
     * @param  string $field
     * @return object
     */
    public function getField($field)
    {
        return isset($this->data[$field])
            ? $this->data[$field]
            : $this->searchField($field);
    }

    /**
     * Search for a field.
     *
     * @param string $search
     * @return
     */
    protected function searchField($search)
    {
        foreach ($this->data as $field) {
            if (method_exists($field, 'getField') && $find = $field->getField($search)) {
                return $find;
            }
        }
    }

    /**
     * This method builds the complete array with the right key => value pairs.
     *
     * @param  array $fields
     * @return array
     */
    public function build($fields)
    {
        $data = [];

        if (Cuztom::isArray($fields)) {
            foreach ($fields as $type => $args) {
                $args = Cuztom::merge($args, array(
                    'metaBox'  => $this,
                    'metaType' => $this->metaType,
                    'object'   => $this->object,
                    'parent'   => $this->id,
                ));

                $field = Field::create($args, $this->values);

                $data[$field->id] = $field;
            }
        }

        return $data;
    }

    /**
     * Adds multipart support to form.
     *
     * @return void
     */
    public static function editFormTag()
    {
        echo ' enctype="multipart/form-data"';
    }
}
