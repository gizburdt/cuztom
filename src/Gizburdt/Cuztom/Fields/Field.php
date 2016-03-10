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
    // Basic
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
    public $row_css_class          = '';

    // Admin
    public $show_admin_column      = false;
    public $admin_column_sortable  = false;
    public $admin_column_filter    = false;

    // ID/name
    public $before_name            = '';
    public $after_name             = '';
    public $before_id              = '';
    public $after_id               = '';

    // Protected
    protected $object                 = null;
    protected $value                  = null;
    protected $meta_type              = null;
    protected $_input_type            = 'text';
    protected $_supports_repeatable   = true;
    protected $_supports_bundle       = true;
    protected $_supports_ajax         = true;

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
        if (! Cuztom::is_empty(@$args['value'])) {
            $this->value = maybe_unserialize(@$args['value']);
        } else {
            $this->value = $this->default_value;
        }
    }

    /**
     * Outputs a field row
     *
     * @since 0.2
     */
    public function output_row($value = null)
    {
        ob_start(); ?>

        <tr>
            <th>
                <label for="<?php echo $this->get_id(); ?>" class="cuztom-label"><?php echo $this->label; ?></label>
                <?php echo ($this->required ? ' <span class="cuztom-required">*</span>' : ''); ?>
                <div class="cuztom-field-description"><?php echo $this->description; ?></div>
            </th>
            <td class="<?php echo $this->get_row_css_class(); ?>" data-id="<?php echo $this->get_id(); ?>">
                <?php echo $this->output(); ?>
            </td>
        </tr>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Output based on type
     *
     * @param  string|array $value
     * @return string
     * @since  0.2
     */
    public function output($value = null)
    {
        $value = (! is_null($value)) ? $value : $this->value;

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
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return $this->_output_input($value) . $this->get_explanation();
    }

    /**
     * Output input field
     *
     * @param  string $value
     * @return string
     */
    public function _output_input($value = null)
    {
        return '<input
            type="'  .$this->get_input_type(). '"
            name="'  .$this->get_name(). '"
            id="'    .$this->get_id(). '"
            class="' .$this->get_css_class(). '"
            value="' .$value. '"
            '        .$this->get_data_attributes(). '
            />';
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

        ob_start(); ?>

        <div class="cuztom-repeatable">
            <?php echo $this->_output_repeatable_control($value); ?>
            <ul class="cuztom-sortable js-cuztom-sortable">
                <?php if (is_array($value)) {
                    foreach ($values as $value) {
                        echo $this->_output_repeatable_item($value, $values);

                        if ($count++ >= $this->limit) {
                            break;
                        }
                    }
                } else {
                    echo $this->_output_repeatable_item($value, $values);
                } ?>
            </ul>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Outputs repeatable item
     *
     * @param  mixed   $value  Default value
     * @param  integer $count  Total count of fields
     * @return string
     */
    public function _output_repeatable_item($value = null, $count = 0)
    {
        ob_start(); ?>

        <li class="cuztom-field cuztom-sortable-item">
            <div class="cuztom-handle-sortable"><a href="#" tabindex="-1"></a></div>
            <?php echo $this->_output($value); ?>
            <?php echo (count($count) > 1 ? '<div class="cuztom-remove-sortable js-cztm-remove-sortable"><a href="#" tabindex="-1"></a></div>' : ''); ?>
        </li>

        <?php $ob = ob_get_clean(); return $ob;
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
        ob_start(); ?>

        <div class="cuztom-control">
            <a class="button-secondary button button-small cuztom-button js-cztm-add-sortable" href="#" data-sortable-type="repeatable" data-field-id="<?php echo $this->get_id(); ?>"><?php _e('Add item', 'cuztom'); ?></a>
            <?php if ($this->limit) : ?>
                <div class="cuztom-counter js-cztm-counter">
                    <span class="current js-current"><?php echo count($value); ?></span>
                    <span class="divider"> / </span>
                    <span class="max js-max"><?php echo $this->limit; ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php $ob = ob_get_clean(); return $output;
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
        return sprintf('<a class="cuztom-ajax-save js-cztm-ajax-save button button-secondary button-small" href="#">%s</a>', __('Save', 'cuztom'));
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
     * Save meta
     *
     * @param  integer $object
     * @param  mixed   $value
     * @return boolean
     * @since  1.6.2
     */
    public function save($object, $values)
    {
        $value = $this->parse_value($values[$this->id]);

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
        return apply_filters('cuztom_field_input_type', $this->_input_type, $this);
    }

    /**
     * Get the complete id
     *
     * @return string
     * @since  3.0
     */
    public function get_id($extra = null)
    {
        return apply_filters('cuztom_field_id', $this->id, $this, $extra);
    }

    /**
     * Get the complete name
     *
     * @return string
     * @since  3.0
     */
    public function get_name()
    {
        return apply_filters('cuztom_field_name', 'cuztom' . $this->before_name . '[' . $this->id . ']' . $this->after_name, $this);
    }

    /**
     * Get the fields css classes
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
     * Get the fields row css classes
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
     * Outputs the fields explanation
     *
     * @return string
     * @since  2.4
     */
    public function get_explanation()
    {
        return apply_filters('cuztom_field_explanation', (! $this->is_repeatable() && $this->explanation ? '<em class="cuztom-field-explanation">' . $this->explanation . '</em>' : ''), $this);
    }

    /**
     * Outputs the fields data attributes
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function get_data_attributes($extra = array())
    {
        foreach (array_merge($this->data_attributes, $extra) as $attribute => $value) {
            if (! is_null($value)) {
                @$output .= ' data-' . $attribute . '="' . $value . '"';
            } elseif (! $value && isset($this->args[Cuztom::uglify($attribute)])) {
                @$output .= 'data-' . $attribute . '="' . $this->args[Cuztom::uglify($attribute)] . '"';
            }
        }

        return apply_filters('cuztom_field_data_attributes', @$output, $this, $extra);
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
