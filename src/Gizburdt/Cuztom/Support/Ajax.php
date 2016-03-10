<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Ajax
{
    /**
     * Add hooks.
     *
     * @since 3.0
     */
    public function add_hooks()
    {
        // Sortable
        add_action('wp_ajax_cuztom_add_repeatable_item', array(&$this, 'add_repeatable_item'));
        add_action('wp_ajax_cuztom_add_bundle_item', array(&$this, 'add_bundle_item'));

        // Save
        add_action('wp_ajax_cuztom_save_field', array(&$this, 'save_field'));
    }

    /**
     * Add (return) repeatable item.
     *
     * @since 3.0
     */
    public function add_repeatable_item()
    {
        $box    = $_POST['cuztom']['box_id'];
        $field  = $_POST['cuztom']['field_id'];
        $field  = self::get_field($field, $box);

        if (! $field) {
            return;
        }

        if (! $field->limit || ($field->limit > $_POST['cuztom']['count'])) {
            echo json_encode(array(
                'status'    => true,
                'item'      => $field->_output_repeatable_item(null, 10)
            ));
        } else {
            echo json_encode(array(
                'status'    => false,
                'message'   => __('Limit reached!', 'cuztom')
            ));
        }

        // wp
        die();
    }

    /**
     * Add (return) bundle item.
     *
     * @since 3.0
     */
    public function add_bundle_item()
    {
        $box    = $_POST['cuztom']['box_id'];
        $field  = $_POST['cuztom']['field_id'];
        $field  = self::get_field($field, $box);

        if (! $field) {
            return;
        }

        if (! $field->limit || ($field->limit > $_POST['cuztom']['count'])) {
            echo json_encode(array(
                'status'    => true,
                'item'      => $field->output_item($_POST['cuztom']['index'])
            ));
        } else {
            echo json_encode(array(
                'status'    => false,
                'message'   => __('Limit reached!', 'cuztom')
            ));
        }

        // wp
        die();
    }

    /**
     * Saves a field.
     *
     * @since 3.0
     */
    public function save_field()
    {
        global $cuztom;

        if ($_POST['cuztom'] && isset($_POST['cuztom']['field_id'])) {
            $box       = $_POST['cuztom']['box_id'];
            $field     = $_POST['cuztom']['field_id'];
            $field     = self::get_field($field, $box);

            $object    = $_POST['cuztom']['object_id'];
            $value     = $_POST['cuztom']['value'];
            $meta_type = $_POST['cuztom']['meta_type'];

            if ($field->save($object, $value)) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        }

        // wp
        die();
    }

    /**
     * Get field object from cuztom global.
     *
     * @since 3.0
     */
    public static function get_field($field, $box)
    {
        global $cuztom;

        return $cuztom->data[$box][$field];
    }
}
