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
     * Fillable.
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
        global $cuztom;

        // Set all properties
        foreach ($this->fillable as $property) {
            $this->$property = isset($data[$property]) ? $data[$property] : $this->$property;
        }

        // Set hard
        $this->id     = $id;
        $this->object = $this->determineObject();
        $this->values = $this->getMetaValues();

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

        foreach ($this->data as $id => $field) {
            if(isset($values[$id])) {
                $field->save($object, $values);
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
        if (is_array($fields) && ! Cuztom::isEmpty($fields)) {
            foreach ($fields as $type => $args) {
                $field = Field::create($args, $this->values);

                $field->metaType = $this->metaType;
                $field->object   = $this->object;

                $data[$field->id] = $field;
            }
        }

        return @$data;
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
