<?php

namespace Gizburdt\Cuztom\Support;

use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;

Guard::directAccess();

class Ajax
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->addHooks();
    }

    /**
     * Add hooks.
     */
    public function addHooks()
    {
        // Sortable
        add_action('wp_ajax_cuztom_add_repeatable_item', array(&$this, 'addRepeatableItem'));
        add_action('wp_ajax_cuztom_add_bundle_item', array(&$this, 'addBundleItem'));

        // More
    }

    /**
     * Add (return) repeatable item.
     */
    public function addRepeatableItem()
    {
        $request = new Request($_POST);

        $count = $request->get('count');
        $field = $request->get('field');
        $box   = $request->get('box');
        $field = self::getField($field, $box);

        if (! $field || ! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $response = ((! $field->limit) || ($field->limit > $count))
            ? new Response(true, array('item' => $field->_outputRepeatableItem(null, $count)))
            : new Response(false, array('message' => __('Limit reached!', 'cuztom')));

        echo $response->toJson();

        // wp
        die();
    }

    /**
     * Add (return) bundle item.
     */
    public function addBundleItem()
    {
        $request = new Request($_POST);

        $count = $request->get('count');
        $index = $request->get('index');
        $field = $request->get('field');
        $field = self::getField($field, $request->get('box'));

        if (! $field || ! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $item = new BundleItem(array_merge(
            $field->original,
            array('parent' => $field, 'index' => $index)
        ));

        $response = (! $field->limit || ($field->limit > $count))
            ? new Response(true, array('item' => $item->output()))
            : new Response(false, array('message' => __('Limit reached!', 'cuztom')));

        echo $response->toJson();

        // wp
        die();
    }

    /**
     * Get field object from cuztom global.
     *
     * @param  string $field
     * @param  string $box
     * @return object
     */
    public static function getField($field, $box)
    {
        global $cuztom;

        return $cuztom->data[$box][$field];
    }
}
