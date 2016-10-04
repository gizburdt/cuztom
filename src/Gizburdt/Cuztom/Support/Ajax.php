<?php

namespace Gizburdt\Cuztom\Support;

use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;

Guard::directAccess();

class Ajax
{
    /**
     * Constructor.
     *
     * @since 3.0
     */
    public function __construct()
    {
        $this->add_hooks();
    }

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
    public function add_repeatable_item($bla)
    {
        $request = new Request($_POST);
        $field   = $request->field;
        $count   = $request->count;
        $field   = self::get_field($field, $request->box);

        if (! $field) {
            return;
        }

        if ((! $field->limit) || ($field->limit > $count)) {
            $response = new Response(true, array('item' => $field->_output_repeatable_item(null, $count)));
        } else {
            $response = new Response(false, array('message' => __('Limit reached!', 'cuztom')));
        }

        echo $response->get();

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
        $request = new Request($_POST);
        $field   = $request->field;
        $count   = $request->count;
        $index   = $request->index;
        $field   = self::get_field($field, $request->box);

        if (! $field) {
            return;
        }

        if (! $field->limit || ($field->limit > $count)) {
            $item = new BundleItem(
                array_merge($field->original, array('parent' => $field, 'index' => $index))
            );

            $response = new Response(true, array('item' => $item->output()));
        } else {
            $response = new Response(false, array('message' => __('Limit reached!', 'cuztom')));
        }

        echo $response->get();

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
        $request = new Request($_POST);

        if ($request->field_id) {
            $field     = $request->field_id;
            $field     = self::get_field($field, $request->box);

            $object    = $request->object_id;
            $value     = $request->value;
            $meta_type = $request->meta_type;

            if ($field->save($object, array($field->id => $value))) {
                $response = new Response(true);
            } else {
                $response = new Response(false);
            }

            echo $response->get();
        }

        // wp
        die();
    }

    /**
     * Get field object from cuztom global.
     *
     * @param  string $field
     * @param  string $box
     * @return object
     * @since  3.0
     */
    public static function get_field($field, $box)
    {
        global $cuztom;

        return $cuztom->data[$box][$field];
    }
}
