<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Hidden;

Guard::directAccess();

class Bundle extends Field
{
    public $type       = 'bundle';
    public $fields     = array();

    /**
     * Output a row
     * @param mixed $value
     * @since 3.0
     */
    public function output_row($value = null)
    {
        echo $this->output_control();

        echo '<tr class="cuztom-bundle">';
        echo '<td class="cuztom-field" ' . $this->output_id() . ' data-id="' . $this->get_id() . '" colspan="2">';
        echo '<div class="cuztom-bundles cuztom-bundles-' . $this->get_id() . '">';
        echo '<ul class="js-cztm-sortable cuztom-sortable" data-cuztom-sortable-type="bundle">';
        $this->output();
        echo '</ul>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';

        echo $this->output_control('bottom');
    }

    /**
     * Outputs a bundle
     * @param mixed $value
     * @since 1.6.5
     */
    public function output($value = null)
    {
        $i = 0;

        if (! empty($this->value) && isset($this->value[0])) :
            foreach ($this->value as $bundle) {
                echo $this->output_item($i);
                $i++;
            } elseif (! empty($this->default_value)) :
            foreach ($this->default_value as $default) {
                echo $this->output_item($i);
                $i++;
            } else :
            echo $this->output_item();
        endif;
    }

    /**
     * Outputs bundle item
     * @param  integer $index
     * @return string
     * @since  3.0
     */
    public function output_item($index = 0)
    {
        // @TODO: Cleanup!
        $output = '<li class="cuztom-sortable-item">';
        $output .= '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"><a href="#"></a></div>';
        $output .= '<fieldset class="cuztom-fieldset">';
        $output .= '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
        foreach ($this->fields as $id => $field) {
            $field->before_name     = '[' . $this->id . '][' . $index. ']';
            $field->after_id        = '_' . $index;
            $field->default_value   = isset($this->default_value[$index][$id]) ? $this->default_value[$index][$id] : $field->default_value;
            $value                  = isset($this->value[$index][$id]) ? $this->value[$index][$id] : '';

            if (! $field instanceof Hidden) {
                $output .= '<tr>';
                $output .= '<th class="cuztom-th">';
                $output .= '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
                $output .= '<div class="cuztom-field-description">' . $field->description . '</div>';
                $output .= '</th>';
                $output .= '<td class="cuztom-td">';

                if ($field->_supports_bundle) {
                    $output .= $field->output($value);
                } else {
                    $output .= '<em>' . __('This input type doesn\'t support the bundle functionality (yet).', 'cuztom') . '</em>';
                }

                $output .= '</td>';
                $output .= '</tr>';
            } else {
                $output .= $field->output($value);
            }
        }
        $output .= '</table>';
        $output .= '</fieldset>';
        $output .= count($this->value) > 1 ? '<div class="cuztom-remove-sortable js-cztm-remove-sortable"><a href="#"></a></div>' : '';
        $output .= '</li>';

        return $output;
    }

    /**
     * Output a control row for a bundle
     * @param string $class
     * @since 3.0
     */
    public function output_control($class = 'top')
    {
        echo '<tr class="cuztom-control cuztom-control-' . $class . '" data-control-for="' . $this->id . '">';
        echo '<td colspan="2">';
        echo '<a class="button-secondary button button-small cuztom-button js-cztm-add-sortable" data-sortable-type="bundle" data-field-id="' . $this->id . '" href="#">';
        echo sprintf('+ %s', __('Add item', 'cuztom'));
        echo '</a>';

        if ($this->limit) {
            echo '<div class="cuztom-counter js-cztm-counter">';
            echo '<span class="current js-current">' . count($this->value) . '</span>';
            echo '<span class="divider"> / </span>';
            echo '<span class="max js-max">' . $this->limit . '</span>';
            echo '</div>';
        }
        echo '</td>';
        echo '</tr>';
    }

    /**
     * Save bundle meta
     * @param integer $object
     * @param array   $values
     * @since 1.6.2
     */
    public function save($object, $values)
    {
        $values = $values[$this->id];
        $values = is_array($values) ? array_values($values) : array();

        foreach ($values as $row => $fields) {
            foreach ($fields as $id => $value) {
                $values[$row][$id] = $this->fields[$id]->parse_value($value);
            }
        }

        parent::save($object, $values);
    }

    /**
     * This method builds the complete array for a bundle
     * @param array      $data
     * @param array|null $values
     * @since 3.0
     */
    public function build($data, $values = null)
    {
        // Unset fields with array
        $this->fields = array();

        // Build fields with objects
        foreach ($data as $type => $field) {
            if (is_string($type) && $type == 'tabs') {
                // $tab->fields = $this->build( $fields );
            } else {
                $field['meta_type'] = $this->meta_type;
                $field['object']    = $this->object;

                $field = Field::create($field);
                $field->repeatable = false;
                $field->ajax = false;

                $this->fields[$field->id] = $field;
            }
        }
    }
}
