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
    public $meta_type;

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = array(
        'id',
        'callback',
        'title',
        'description',
        'fields',
    );

    /**
     * Get object id.
     *
     * @return int
     */
    abstract public function determine_object();

    /**
     * Get meta values.
     *
     * @return array
     */
    abstract public function get_meta_values();

    /**
     * Construct for all meta types, creates title (and description).
     *
     * @param int   $id   Box ID
     * @param array $data Array of fields
     * @since 1.6.4
     */
    public function __construct($id, $data)
    {
        global $cuztom;

        // Set all properties
        foreach ($this->fillable as $property) {
            $this->$property = isset($data[$property]) ? $data[$property] : $this->$property;
        }

        // Set hard
        $this->id     = $id;
        $this->object = $this->determine_object();
        $this->values = $this->get_meta_values();

        // Callback
        if (! $this->callback) {
            $this->callback = array(&$this, 'output');

            // Build the meta box and fields
            $this->data = $this->build($this->fields);

            // Assign global
            $cuztom->data[$this->id] = $this->data;
        }
    }

    /**
     * Main callback for meta.
     *
     * @since 0.2
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
     * @since 2.6
     */
    public function save($object, $values)
    {
        // Loop through each field
        foreach ($this->data as $id => $field) {
            $field->save($object, $values);
        }
    }

    /**
     * This method builds the complete array with the right key => value pairs.
     *
     * @param  array $fields
     * @return array
     * @since  1.1
     */
    public function build($fields)
    {
        if (is_array($fields) && ! Cuztom::is_empty($fields)) {
            foreach ($fields as $type => $args) {
                $field            = Field::create($args, $this->values);
                $field->meta_type = $this->meta_type;
                $field->object    = $this->object;

                $data[$field->id] = $field;
            }
        }

        return @$data;
    }

    /**
     * Check what kind of meta we're dealing with.
     *
     * @param  string $meta_type
     * @return bool
     * @since  2.3
     */
    public function is_meta_type($meta_type)
    {
        return $this->_meta_type == $meta_type;
    }

    /**
     * Adds multipart support to form.
     *
     * @since 0.2
     */
    public static function edit_form_tag()
    {
        echo ' enctype="multipart/form-data"';
    }
}
