<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Field\Bundle;
use Gizburdt\Cuztom\Field\Tabs;
use Gizburdt\Cuztom\Field\Accordion;

Guard::directAccess();

abstract class Field
{
    public $id                     = null;
    public $type                   = null;
    public $label                  = '';
    public $description            = '';
    public $explanation            = '';
    public $default_value          = '';
    public $options                = array(); // Only used for radio, checkboxes etc.
    public $args                   = array(); // Specific args for the field
    public $required               = false;
    public $repeatable             = false;
    public $limit                  = null;
    public $ajax                   = false;
    public $data_attributes        = array();
    public $css_class              = '';

    public $show_admin_column      = false;
    public $admin_column_sortable  = false;
    public $admin_column_filter    = false;

    public $before_name            = '';
    public $after_name             = '';
    public $before_id              = '';
    public $after_id               = '';

    protected $object                 = null;
    protected $value                  = null;
    protected $meta_type              = null;

    protected $_supports_repeatable   = true;
    protected $_supports_bundle       = true;
    protected $_supports_ajax         = true;
    protected $_input_type            = 'text';

    /**
     * Constructs a Cuztom_Field
     *
     * @param array $args
     * @since 0.3.3
     */
    public function __construct($args)
    {
        $properties = array_keys(get_class_vars(get_called_class()));

        // Set all properties
        foreach ($properties as $property) {
            $this->$property = (isset($args[$property]) ? $args[$property] : $this->$property);
        }

        // Repeatable?
        if ($this->is_repeatable()) {
            $this->after_name = '[]';
        }

        // Value
        if (isset($args['value'])) {
            $this->value = maybe_unserialize(@$args['value']);
        }
    }

    /**
     * Outputs a field row
     *
     * @since 0.2
     */
    public function output_row($value = null)
    {
        $ob = '<tr>';
        $ob .= '<th>';
        $ob .= '<label for="'.$this->get_id().'" class="cuztom-label">'.$this->label.'</label>';
        $ob .= ($this->required ? ' <span class="cuztom-required">*</span>' : '');
        $ob .= '<div class="cuztom-field-description">'.$this->description.'</div>';
        $ob .= '</th>';
        $ob .= '<td class="cuztom-field js-cuztom-field '.($this->is_ajax() ? 'cuztom-field-ajax' : '').'" id="'.$this->get_id().'" data-id="'.$this->get_id().'">';
        $ob .= $this->output($this->value);
        $ob .= '</td>';
        $ob .= '</tr>';

        return $ob;
    }

    /**
     * Outputs a field based on its type
     *
     * @since 0.2
     */
    public function output($value = null)
    {
        $value = (!is_null($value)) ? $value : $this->value;

        if ($this->is_repeatable()) {
            return $this->_output_repeatable($value);
        } elseif ($this->is_ajax()) {
            return $this->_output_ajax($value);
        } else {
            return $this->_output($value);
        }
    }

    /**
     * Output field
     *
     * @param  mixed $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return '<input type="'.$this->get_input_type().'" '.$this->output_name().' '.$this->output_id().' '.$this->output_css_class().' value="'.(strlen($value) > 0 ? $value : $this->default_value).'" '.$this->output_data_attributes().' />'.$this->output_explanation();
    }

    /**
     * Outputs the field, ready for repeatable functionality
     *
     * @param  mixed $value
     * @return string
     * @since  2.0
     */
    public function _output_repeatable($value = null)
    {
        $values = $value;
        $count  = 0;

        $ob = '<div class="cuztom-repeatable">';
        $ob .= $this->_output_repeatable_control($value);
        $ob .= '<ul class="cuztom-sortable js-cuztom-sortable">';
        if (is_array($value)) {
            foreach ($values as $value) {
                $ob .= $this->_output_repeatable_item($value, $values);

                if ($count++ >= $this->limit) {
                    break;
                }
            }
        } else {
            $ob .= $this->_output_repeatable_item($value, $values);
        }
        $ob .= '</ul>';
        $ob .= '</div>';

        return $ob;
    }

    /**
     * Outputs repeatable item
     *
     * @param  mixed   $value  Default value
     * @param  integer $values Total count of fields
     * @return string
     */
    public function _output_repeatable_item($value = null, $values = 0)
    {
        return '<li class="cuztom-field cuztom-sortable-item"><div class="cuztom-handle-sortable"><a href="#" tabindex="-1"></a></div>' . $this->_output($value) . (count($values) > 1 ? '<div class="cuztom-remove-sortable js-cztm-remove-sortable"><a href="#" tabindex="-1"></a></div>' : '') . '</li>';
    }

    /**
     * Outputs repeatable control
     *
     * @param  mixed $value
     * @return string
     * @since  3.0
     */
    public function _output_repeatable_control($value)
    {
        // @TODO: Convert to echo?
        $output = '<div class="cuztom-control">';
        $output .= '<a class="button-secondary button button-small cuztom-button js-cztm-add-sortable" href="#" data-sortable-type="repeatable" data-field-id="' . $this->id . '">' . __('Add item', 'cuztom') . '</a>';
        if ($this->limit) {
            $output .= '<div class="cuztom-counter js-cztm-counter">';
            $output .= '<span class="current js-current">' . count($value) . '</span>';
            $output .= '<span class="divider"> / </span>';
            $output .= '<span class="max js-max">' . $this->limit . '</span>';
            $output .= '</div>';
        }
        $output .= '</div>';

        return $output;
    }

    /**
     * Outputs the field, ready for ajax save
     *
     * @param  mixed $value
     * @return string
     * @since  2.0
     */
    public function _output_ajax($value = null)
    {
        return $this->_output($value) . $this->_output_ajax_button();
    }

    /**
     * Outputs ajax save button
     *
     * @return string
     * @since  3.0
     */
    public function _output_ajax_button()
    {
        return '<a class="cuztom-ajax-save js-cztm-ajax-save button button-secondary button-small" href="#">' . __('Save', 'cuztom') . '</a>';
    }

    /**
     * Parse value
     *
     * @param  mixed $value
     * @return mixed
     * @since  2.8
     */
    public function parse_value($value)
    {
        return $value;
    }

    /**
     * Get value
     *
     * @param  string|array $values
     * @return mixed
     */
    public function get_value($values = null)
    {
        if (is_null($values)) {
            $value = $this->value;
        } elseif (is_array($values) && isset($values[$this->id])) {
            $value = $values[$this->id];
        } else {
            $value = $values;
        }

        return $this->parse_value($value);
    }

    /**
     * Save meta
     *
     * @param  integer $object
     * @param  mixed   $value
     * @return boolean
     * @since  1.6.2
     */
    public function save($object, $values)
    {
        $value = $this->get_value($values);

        // Don't save when empty
        if (Cuztom::is_empty($value)) {
            return;
        }

        // Save to respective content-type
        switch ($this->meta_type) :
            case 'user' :
                update_user_meta($object, $this->id, $value);
        return true;
        break;
        case 'term' :
                update_term_meta($object, $this->id, $value);
        return true;
        break;
        case 'post' : default :
                update_post_meta($object, $this->id, $value);
        return true;
        break;
        endswitch;

        // Default
        return false;
    }

    /**
     * Returns the input type
     *
     * @return string
     * @since  3.0
     */
    public function get_input_type()
    {
        return $this->_input_type;
    }

    /**
     * Get the complete id
     *
     * @return string
     * @since  3.0
     */
    public function get_id()
    {
        return $this->before_id . $this->id . $this->after_id;
    }

    /**
     * Get the complete name
     *
     * @return string
     * @since  3.0
     */
    public function get_name()
    {
        return $this->before_name . '[' . $this->id . ']' . $this->after_name;
    }

    /**
     * Outputs the fields name attribute
     *
     * @param  string $overwrite
     * @return string
     * @since  2.4
     */
    public function output_name($overwrite = null)
    {
        return apply_filters('cuztom_field_output_name', ($overwrite ? 'name="' . $overwrite . '"' : 'name="cuztom' . $this->get_name() . '"'), $overwrite, $this);
    }

    /**
     * Outputs the fields id attribute
     *
     * @param  string $overwrite
     * @return string
     * @since  2.4
     */
    public function output_id($overwrite = null)
    {
        return apply_filters('cuztom_field_output_id', ($overwrite ? 'id="' . $overwrite . '"' : 'id="' . $this->get_id() . '"'), $overwrite, $this);
    }

    /**
     * Outputs the fields css classes
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function output_css_class($extra = '')
    {
        return 'class="'.apply_filters('cuztom_field_output_css_class', $this->css_class, $this, $extra).'"';
    }

    /**
     * Outputs the fields data attributes
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function output_data_attributes($extra = array())
    {
        foreach (array_merge($this->data_attributes, $extra) as $attribute => $value) {
            if (! is_null($value)) {
                $output = 'data-' . $attribute . '="' . $value . '"';
            } elseif (! $value && isset($this->args[Cuztom::uglify($attribute)])) {
                $output = 'data-' . $attribute . '="' . $this->args[Cuztom::uglify($attribute)] . '"';
            }
        }

        return apply_filters('cuztom_field_output_data_attributes', @$output, $extra, $this);
    }

    /**
     * Outputs the for attribute
     *
     * @param  string $for
     * @return string
     * @since  2.4
     */
    public function output_for_attribute($for = null)
    {
        return apply_filters('cuztom_field_output_for_attribute', ($for ? 'for="' . $for . '"' : ''), $for, $this);
    }

    /**
     * Outputs the fields explanation
     *
     * @return string
     * @since  2.4
     */
    public function output_explanation()
    {
        return apply_filters('cuztom_field_output_explanation', (! $this->is_repeatable() && $this->explanation ? '<em class="cuztom-field-explanation">' . $this->explanation . '</em>' : ''), $this);
    }

    /**
     * Outputs the fields column content
     *
     * @param integer $post_id
     * @since 3.0
     */
    public function output_column_content($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        if (!empty($meta) && $this->is_repeatable()) {
            echo implode($meta, ', ');
        } else {
            echo $meta;
        }
    }

    /**
     * Check what kind of meta we're dealing with
     *
     * @param  string  $meta_type
     * @return boolean
     * @since  3.0
     */
    public function is_meta_type($meta_type)
    {
        return $this->meta_type == $meta_type;
    }

    /**
     * check if the field is in ajax mode
     *
     * @return boolean
     * @since  3.0
     */
    public function is_ajax()
    {
        return $this->ajax && $this->_supports_ajax;
    }

    /**
     * Check if the field is in repeatable mode
     *
     * @return boolean
     * @since  3.0
     */
    public function is_repeatable()
    {
        return $this->repeatable && $this->_supports_repeatable;
    }

    /**
     * Check if the field is tabs or accordion
     *
     * @return boolean
     * @since  3.0
     */
    public function is_tabs()
    {
        return ($this instanceof Tabs || $this instanceof Accordion);
    }

    /**
     * Check if the field is tabs or accordion
     *
     * @return boolean
     * @since  3.0
     */
    public function is_bundle()
    {
        return ($this instanceof Bundle);
    }

    /**
     * Creates and returns a field object
     *
     * @param  array $args
     * @return object|boolean
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
