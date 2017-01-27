<?php

namespace Gizburdt\Cuztom\Support;

use Gizburdt\Cuztom\Cuztom;
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
        // Repeatable
        add_action('wp_ajax_cuztom_setup_repeatable_list', array(&$this, 'setupRepeatableList'));
        add_action('wp_ajax_cuztom_add_repeatable_item', array(&$this, 'addRepeatableItem'));

        // Bundle
        add_action('wp_ajax_cuztom_setup_bundle_list', array(&$this, 'setupBundleList'));
        add_action('wp_ajax_cuztom_add_bundle_item', array(&$this, 'addBundleItem'));

        // More
    }

    /**
     * Setup repeatable list on init.
     *
     * @return mixed
     */
    public function setupRepeatableList()
    {
        $request = new Request($_POST);
        $field   = self::getField($request);

        if (Cuztom::isArray($field->value)) {
            foreach ($field->value as $value) {
                $data[] = $field->_outputRepeatableItem($value);
            }
        }

        echo (new Response(true, @$data))->toJson();

        // wp
        die();
    }

    /**
     * Add (return) repeatable item.
     */
    public function addRepeatableItem()
    {
        $request = new Request($_POST);
        $field   = self::getField($request);
        $count   = $request->get('count');

        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $response = ((! $field->limit) || ($field->limit > $count))
            ? new Response(true, $field->_outputRepeatableItem(null))
            : new Response(false, __('Limit reached!', 'cuztom'));

        echo $response->toJson();

        // wp
        die();
    }

    /**
     * Setup bundle list on init.
     *
     * @return mixed
     */
    public function setupBundleList()
    {
        $request = new Request($_POST);
        $bundle  = self::getField($request);

        if (Cuztom::isArray($bundle->data)) {
            foreach ($bundle->data as $item) {
                $data[] = $item->output();
            }
        }

        echo (new Response(true, @$data))->toJson();

        // wp
        die();
    }

    /**
     * Add (return) bundle item.
     */
    public function addBundleItem()
    {
        $request = new Request($_POST);
        $field   = self::getField($request);
        $count   = $request->get('count');
        $index   = $request->get('index');

        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $data = Cuztom::view('fields/bundle/item', array(
            'item' => new BundleItem(Cuztom::merge(
                $field->original,
                array(
                    'parent' => $field,
                    'index'  => $index
                )
            ))
        ));

        $response = (! $field->limit || ($field->limit > $count))
            ? new Response(true, $data)
            : new Response(false, __('Limit reached!', 'cuztom'));

        echo $response->toJson();

        // wp
        die();
    }

    /**
     * Get field object from cuztom global.
     *
     * @param  string|object $field
     * @param  string|null   $box
     * @return object
     */
    public static function getField($field, $box = null)
    {
        if (is_null($box)) {
            $request = $field;
            $box     = $request->get('box');
            $field   = $request->get('field');

            return Cuztom::getBox($box)->getField($field);
        }

        return Cuztom::getBox($box)->getField($field);
    }
}
