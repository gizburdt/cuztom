<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

abstract class Field
{
    /**
     * All original args.
     *
     * @var array
     */
    public $original;

    /**
     * Base.
     *
     * @var mixed
     */
    public $object = null;
    public $value = null;
    public $metaBox = null;
    public $metaType = null;
    public $view = 'text';
    public $inputType = 'text';

    /**
     * Before/after id/name.
     *
     * @var mixed
     */
    public $beforeName = '';
    public $afterName = '';
    public $beforeId = '';
    public $afterId = '';

    /**
     * Special.
     *
     * @var mixed
     */
    public $parent;

    /**
     * Fillables.
     *
     * @var mixed
     */
    public $id = null;
    public $type = null;
    public $label = '';
    public $description = '';
    public $explanation = '';
    public $default_value = '';
    public $options = [];
    public $args = [];
    public $required = false;
    public $repeatable = false;
    public $limit = null;
    public $html_attributes = [];
    public $css_class = '';
    public $cell_css_class = '';
    public $show_admin_column = false;
    public $admin_column_sortable = false;
    public $admin_column_filter = false;

    /**
     * Merges.
     *
     * @var mixed
     */
    protected $merges = [
        'html_attributes',
    ];

    /**
     * Construct.
     *
     * @param  array  $args
     * @param  array  $values
     */
    public function __construct($args, $values = null)
    {
        // Original
        $this->original = $args;

        // Set all properties
        foreach ($args as $property => $value) {
            if (property_exists($this, $property)) {
                if (in_array($property, $this->merges) && isset($args[$property])) {
                    $this->$property = array_merge($args[$property], $this->$property);
                }

                $this->$property = (isset($args[$property]) ? $args[$property] : $this->$property);
            }
        }

        // Repeatable?
        if ($this->isRepeatable()) {
            $this->afterName = '[]';
        }

        // Value
        $this->value = $this->substractValue($values);

        // Do
        do_action('cuztom_field_init', $this);
    }

    /**
     * Outputs a field cell.
     *
     * @param  string|array  $value
     * @param  string  $view
     */
    public function outputCell($value = null)
    {
        return Cuztom::view('fields/cell/default', [
            'field' => $this,
            'value' => $value,
        ]);
    }

    /**
     * Output based on type.
     *
     * @param  string|array  $value
     * @param  string  $value
     * @return string
     */
    public function output($value = null)
    {
        $value = is_null($value) ? $this->value : $value;

        return $this->isRepeatable()
            ? $this->outputRepeatable().$this->getExplanation()
            : $this->outputInput($value).$this->getExplanation();
    }

    /**
     * Output field.
     *
     * @param  string|array  $value
     * @param  string  $view
     * @return string
     */
    public function outputInput($value = null, $view = null)
    {
        $view = $view ? $view : $this->getView();

        return Cuztom::view('fields/'.$view, [
            'field' => $this,
            'value' => $value,
        ]);
    }

    /**
     * Repeatable output.
     *
     * @return string
     */
    public function outputRepeatable($value = null)
    {
        return Cuztom::view('fields/repeatable/repeatable', [
            'field'  => $this,
            'values' => $value,
        ]);
    }

    /**
     * Outputs repeatable control.
     *
     * @param  mixed  $value
     * @return string
     */
    public function outputRepeatableControl()
    {
        return Cuztom::view('fields/repeatable/control', [
            'field' => $this,
        ]);
    }

    /**
     * Parse value.
     *
     * @param  mixed  $value.
     * @return mixed
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Save meta.
     *
     * @param  int  $object
     * @param  mixed  $value
     * @return bool
     */
    public function save($object, $values)
    {
        $value = isset($values[$this->id])
            ? apply_filters('cuztom_field_save_value', $this->parseValue($values[$this->id]), $this)
            : false;

        // Do
        do_action('cuztom_field_save', $this);

        // Save to respective content-type
        switch ($this->metaType) {
            case 'user':
                return (bool) update_user_meta($object, $this->id, $value);
            case 'term':
                return (bool) update_term_meta($object, $this->id, $value);
            case 'post':
                return (bool) update_post_meta($object, $this->id, $value);
        }

        // Default
        return false;
    }

    /**
     * Returns the input type.
     *
     * @return string
     */
    public function getInputType()
    {
        return apply_filters('cuztom_field_input_type', $this->inputType, $this);
    }

    /**
     * Returns the view name.
     *
     * @return string
     */
    public function getView()
    {
        return apply_filters('cuztom_field_view', $this->view, $this);
    }

    /**
     * Get the complete id.
     *
     * @return string
     */
    public function getId($extra = null)
    {
        $id = $this->beforeId.$this->id.$this->afterId;

        if (! Cuztom::isEmpty($extra)) {
            $id = $id.'_'.$extra;
        }

        return apply_filters('cuztom_field_id', $id, $this, $extra);
    }

    /**
     * Get the complete name.
     *
     * @return string
     */
    public function getName()
    {
        return apply_filters('cuztom_field_name', 'cuztom'.$this->beforeName.'['.$this->id.']'.$this->afterName, $this);
    }

    /**
     * Get the fields css classes.
     *
     * @param  array  $extra
     * @return string
     */
    public function getCssClass($extra = null)
    {
        $class = 'cuztom-input '.$this->css_class;

        if (! Cuztom::isEmpty($extra)) {
            $class = $class.' '.$extra;
        }

        return apply_filters('cuztom_field_css_class', $class, $this, $extra);
    }

    /**
     * Get the fields cell css classes.
     *
     * @param  array  $extra
     * @return string
     */
    public function getCellCssClass($extra = null)
    {
        return apply_filters('cuztom_field_cell_css_class', 'cuztom-field '.$this->cell_css_class, $this, $extra);
    }

    /**
     * Outputs the fields explanation.
     *
     * @return string
     */
    public function getExplanation()
    {
        return apply_filters(
            'cuztom_field_explanation',
            $this->explanation ? '<em class="cuztom-field__explanation" v-cloak>'.$this->explanation.'</em>' : '', $this
        );
    }

    /**
     * Outputs the fields data attributes.
     *
     * @param  array  $extra
     * @return string
     */
    public function getDataAttributes($extra = [])
    {
        $output = '';

        foreach (array_merge($this->html_attributes, $extra) as $attribute => $value) {
            if (! is_null($value)) {
                $output .= $attribute.'="'.$value.'"';
            } elseif (! $value && isset($this->args[Cuztom::uglify($attribute)])) {
                $output .= $attribute.'="'.$this->args[Cuztom::uglify($attribute)].'"';
            }
        }

        return apply_filters('cuztom_field_html_attributes', $output, $this, $extra);
    }

    /**
     * Outputs the fields column content.
     *
     * @param  int  $id
     */
    public function outputColumnContent($id)
    {
        $meta = get_post_meta($id, $this->id, true);

        if (! empty($meta) && $this->isRepeatable()) {
            echo implode($meta, ', ');
        } else {
            echo $meta;
        }
    }

    /**
     * Check what kind of meta we're dealing with.
     *
     * @param  string  $metaType
     * @return bool
     */
    public function isMetaType($metaType)
    {
        return $this->metaType == $metaType;
    }

    /**
     * Check if the field is in repeatable mode.
     *
     * @return bool
     */
    public function isRepeatable()
    {
        return $this->repeatable;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     */
    public function isTabs()
    {
        return $this instanceof Tabs || $this instanceof Accordion;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     */
    public function isBundle()
    {
        return $this instanceof Bundle;
    }

    /**
     * Substract value of field from values array.
     *
     * @param  array  $values
     * @return string
     */
    public function substractValue($values)
    {
        if (isset($values[$this->id]) && ! Cuztom::isEmpty($values[$this->id])) {
            if (is_array($values[$this->id])) {
                $value = isset($values[$this->id][0]) ? maybe_unserialize($values[$this->id][0]) : null;
            } else {
                $value = maybe_unserialize($values[$this->id]);
            }
        } else {
            $value = $this->default_value;
        }

        return apply_filters('cuztom_field_value', $value, $this);
    }

    /**
     * Creates and returns a field object.
     *
     * @param  array  $args
     * @return object|bool
     */
    public static function create($args, $values)
    {
        $type = is_array($args) ? $args['type'] : $args;
        $class = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $class = "Gizburdt\\Cuztom\\Fields\\$class";

        if (class_exists($class)) {
            $field = new $class($args, $values);

            Cuztom::addField($field);

            return $field;
        }

        return false;
    }
}
