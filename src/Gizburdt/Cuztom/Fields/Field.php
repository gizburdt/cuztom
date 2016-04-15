<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Field\Accordion;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

abstract class Field
{
    // Basic
    public $id                      = null;
    public $type                    = null;
    public $label                   = '';
    public $description             = '';
    public $explanation             = '';
    public $default_value           = '';
    public $options                 = array();
    public $args                    = array();
    public $required                = false;
    public $repeatable              = false;
    public $limit                   = null;
    public $ajax                    = false;
    public $data_attributes         = array();
    public $css_class               = '';
    public $row_css_class           = '';

    // Admin
    public $show_admin_column       = false;
    public $admin_column_sortable   = false;
    public $admin_column_filter     = false;

    // ID/name
    public $before_name             = '';
    public $after_name              = '';
    public $before_id               = '';
    public $after_id                = '';

    // Protected
    protected $_object              = null;
    protected $_value               = null;
    protected $_meta_type           = null;
    protected $_view                = 'text';
    protected $_input_type          = 'text';

    // Support
    protected $_supports_repeatable = true;
    protected $_supports_bundle     = true;
    protected $_supports_ajax       = true;

    /**
     * Constructs a Cuztom_Field.
     *
     * @param array $args
     * @since 0.3.3
     */
    public function __construct($args)
    {
        $properties = array_keys(get_class_vars(get_called_class()));

        // Set all properties
        foreach ($properties as $property) {
            if (! Cuztom::starts_with($property, '_')) {
                $this->$property = (isset($args[$property]) ? $args[$property] : $this->$property);
            }
        }

        // Repeatable?
        if ($this->is_repeatable()) {
            $this->after_name = '[]';
        }

        // Value
        if (! Cuztom::is_empty(@$args['_value'])) {
            $this->_value = maybe_unserialize(@$args['_value']);
        } else {
            $this->_value = $this->default_value;
        }
    }

    /**
     * Outputs a field row.
     *
     * @param string|array $value
     * @pram  string       $view
     * @since 0.2
     */
    public function output_row($value = null, $view = null)
    {
        $view = $view ? $view : 'text';

        Cuztom::view('fields/row/'.$view, array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Output based on type.
     *
     * @param  string|array $value
     * @param  string       $value
     * @return string
     * @since  0.2
     */
    public function output($value = null, $view = null)
    {
        $value = (! is_null($value)) ? $value : $this->_value;

        if ($this->is_repeatable()) {
            return $this->_output_repeatable($value);
        } elseif ($this->is_ajax()) {
            return $this->_output_ajax($value);
        } else {
            return $this->_output($value);
        }
    }

    /**
     * Output field.
     *
     * @param  string|array $value
     * @param  string       $view
     * @return string
     * @since  2.4
     */
    public function _output($value = null, $view = null)
    {
        return $this->_output_input($value).$this->get_explanation();
    }

    /**
     * Output input field.
     *
     * @param  string $value
     * @param  string $view
     * @return string
     */
    public function _output_input($value = null, $view = null)
    {
        $view = $view ? $view : $this->get_view();

        Cuztom::view('fields/'.$view, array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Outputs the field, ready for repeatable functionality.
     *
     * @param  mixed  $value
     * @param  string $view
     * @return string
     * @since  2.0
     */
    public function _output_repeatable($value = null, $view = null)
    {
        $view   = $view ? $view : 'repeatable';
        $count  = 0;

        Cuztom::view('fields/repeatable/'.$view, array(
            'field'  => $this,
            'values' => $value,
            'count'  => $count
        ));
    }

    /**
     * Outputs repeatable item.
     *
     * @param  mixed  $value Default value
     * @param  int    $count Total count of fields
     * @return string
     */
    public function _output_repeatable_item($value = null, $count = 0)
    {
        ob_start();

        Cuztom::view('fields/repeatable/item', array(
            'field' => $this,
            'value' => $value,
            'count' => $count
        ));

        return ob_get_clean();
    }

    /**
     * Outputs repeatable control.
     *
     * @param  mixed  $value
     * @return string
     * @since  3.0
     */
    public function _output_repeatable_control($value)
    {
        Cuztom::view('fields/repeatable/control', array(
            'field' => $this,
            'value' => $value,
            'count' => count($value)
        ));
    }

    /**
     * Outputs the field, ready for ajax save.
     *
     * @param  mixed  $value
     * @return string
     * @since  2.0
     */
    public function _output_ajax($value = null)
    {
        return $this->_output($value).$this->_output_ajax_button();
    }

    /**
     * Outputs ajax save button.
     *
     * @return string
     * @since  3.0
     */
    public function _output_ajax_button()
    {
        return sprintf('<a class="cuztom-ajax-save js-cuztom-ajax-save button button-secondary button-small" href="#">%s</a>', __('Save', 'cuztom'));
    }

    /**
     * Parse value.
     *
     * @param  mixed $value.
     * @return mixed
     * @since  2.8
     */
    public function parse_value($value)
    {
        return $value;
    }

    /**
     * Save meta.
     *
     * @param  int   $object
     * @param  mixed $value
     * @return bool
     * @since  1.6.2
     */
    public function save($object, $values)
    {
        $value = $this->parse_value($values[$this->id]);

        // Save to respective content-type
        switch ($this->_meta_type) {
            case 'user':
                update_user_meta($object, $this->id, $value);

                return true;
            break;
            case 'term':
                update_term_meta($object, $this->id, $value);

                return true;
            break;
            case 'post': default:
                update_post_meta($object, $this->id, $value);

                return true;
            break;
        }

        // Default
        return false;
    }

    /**
     * Return the value.
     *
     * @return mixed
     */
    public function get_value()
    {
        return $this->_value;
    }

    /**
     * Returns the input type.
     *
     * @return string
     * @since  3.0
     */
    public function get_input_type()
    {
        return apply_filters('cuztom_field_input_type', $this->_input_type, $this);
    }

    /**
     * Returns the view name.
     *
     * @return string
     * @since  3.0
     */
    public function get_view()
    {
        return apply_filters('cuztom_field_view', $this->_view, $this);
    }

    /**
     * Get the complete id.
     *
     * @return string
     * @since  3.0
     */
    public function get_id($extra = null)
    {
        return apply_filters('cuztom_field_id', $this->before_id.$this->id.$this->after_id, $this, $extra);
    }

    /**
     * Get the complete name.
     *
     * @return string
     * @since  3.0
     */
    public function get_name()
    {
        return apply_filters('cuztom_field_name', 'cuztom'.$this->before_name.'['.$this->id.']'.$this->after_name, $this);
    }

    /**
     * Get the fields css classes.
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function get_css_class($extra = null)
    {
        return apply_filters('cuztom_field_css_class', 'cuztom-input '.$this->css_class, $this, $extra);
    }

    /**
     * Get the fields row css classes.
     *
     * @param  array  $extra
     * @return string
     * @since  3.0
     */
    public function get_row_css_class($extra = null)
    {
        return apply_filters('cuztom_field_row_css_class', 'cuztom-field js-cuztom-field '.$this->row_css_class, $this, $extra);
    }

    /**
     * Outputs the fields explanation.
     *
     * @return string
     * @since  2.4
     */
    public function get_explanation()
    {
        return apply_filters('cuztom_field_explanation', (! $this->is_repeatable() && $this->explanation ? '<em class="cuztom-field-explanation">'.$this->explanation.'</em>' : ''), $this);
    }

    /**
     * Outputs the fields data attributes.
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function get_data_attributes($extra = array())
    {
        foreach (array_merge($this->data_attributes, $extra) as $attribute => $value) {
            if (! is_null($value)) {
                @$output .= ' data-'.$attribute.'="'.$value.'"';
            } elseif (! $value && isset($this->args[Cuztom::uglify($attribute)])) {
                @$output .= 'data-'.$attribute.'="'.$this->args[Cuztom::uglify($attribute)].'"';
            }
        }

        return apply_filters('cuztom_field_data_attributes', @$output, $this, $extra);
    }

    /**
     * Outputs the fields column content.
     *
     * @param int $post_id
     * @since 3.0
     */
    public function output_column_content($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        if (! empty($meta) && $this->is_repeatable()) {
            echo implode($meta, ', ');
        } else {
            echo $meta;
        }
    }

    /**
     * Check what kind of meta we're dealing with.
     *
     * @param  string $meta_type
     * @return bool
     * @since  3.0
     */
    public function is_meta_type($meta_type)
    {
        return $this->_meta_type == $meta_type;
    }

    /**
     * check if the field is in ajax mode.
     *
     * @return bool
     * @since  3.0
     */
    public function is_ajax()
    {
        return $this->ajax && $this->_supports_ajax;
    }

    /**
     * Check if the field is in repeatable mode.
     *
     * @return bool
     * @since  3.0
     */
    public function is_repeatable()
    {
        return $this->repeatable && $this->_supports_repeatable;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     * @since  3.0
     */
    public function is_tabs()
    {
        return $this instanceof \Gizburdt\Cuztom\Fields\Tabs || $this instanceof \Gizburdt\Cuztom\Fields\Accordion;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     * @since  3.0
     */
    public function is_bundle()
    {
        return $this instanceof \Gizburdt\Cuztom\Fields\Bundle;
    }

    /**
     * Creates and returns a field object.
     *
     * @param  array       $args
     * @return object|bool
     * @since  3.0
     */
    public static function create($args)
    {
        $class = str_replace(' ', '', ucwords(str_replace('_', ' ', $args['type'])));
        $class = "Gizburdt\\Cuztom\\Fields\\$class";

        if (class_exists($class)) {
            return new $class($args);
        }

        return false;
    }
}
