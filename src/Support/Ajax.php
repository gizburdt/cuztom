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
        add_action('wp_ajax_cuztom_add_repeatable_item', array(&$this, 'addRepeatableItem'));
        add_action('wp_ajax_cuztom_add_bundle_item', array(&$this, 'addBundleItem'));
    }

    /**
     * Add (return) repeatable item.
     *
     * @since 3.0
     */
    public function addRepeatableItem($bla)
    {
        $request = new Request($_POST);
        $field   = $request->field;
        $count   = $request->count;
        $field   = self::getField($field, $request->box);

        if (! $field || ! Guard::verifyAjaxNonce('cuztom', 'security')) {
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
    public function addBundleItem()
    {
        $request = new Request($_POST);
        $field   = $request->field;
        $count   = $request->count;
        $index   = $request->index;
        $field   = self::getField($field, $request->box);

        if (! $field || ! Guard::verifyAjaxNonce('cuztom', 'security')) {
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
     * Get field object from cuztom global.
     *
     * @param  string $field
     * @param  string $box
     * @return object
     * @since  3.0
     */
    public static function getField($field, $box)
    {
        global $cuztom;

        return $cuztom->data[$box][$field];
    }
}
