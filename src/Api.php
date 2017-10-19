<?php

namespace Gizburdt\Cuztom;

use Gizburdt\Cuztom\Fields\Bundle\Item as BundleItem;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Str;

Guard::directAccess();

class Api
{
    /**
     * Request.
     *
     * @var object
     */
    protected static $request;

    /**
     * Hooks.
     *
     * @var array
     */
    protected $hooks = array(
        'setup_repeatable_list',
        'add_repeatable_item',
        'setup_bundle_list',
        'add_bundle_item',
    );

    /**
     * Constructor.
     */
    public function init()
    {
        self::$request = new Request($_POST);

        $this->addHooks();

        // Do
        do_action('cuztom_ajax_init');
    }

    /**
     * Add hooks.
     */
    public function addHooks()
    {
        foreach ($this->hooks as $name => $method) {
            add_action("wp_ajax_cuztom_$name", array($this, Str::camel($method)));
        }

        do_action('cuztom_ajax_hooks');
    }

    /**
     * Setup repeatable list on init.
     *
     * @return mixed
     */
    public function setupRepeatableList()
    {
        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $data  = array();
        $field = self::getField();

        if (Cuztom::isArray($field->value)) {
            foreach ($field->value as $value) {
                $data[] = $field->outputInput($value);
            }
        }

        echo (new Response(true, $data))->toJson();

        // wp
        die();
    }

    /**
     * Add (return) repeatable item.
     */
    public function addRepeatableItem()
    {
        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $field = self::getField();
        $count = self::$request->get('count');

        $response = ((! $field->limit) || ($field->limit > $count))
            ? new Response(true, $field->outputInput())
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
        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $data   = array();
        $bundle = self::getField();

        if (Cuztom::isArray($bundle->data)) {
            foreach ($bundle->data as $item) {
                $data[] = $item->output();
            }
        }

        echo (new Response(true, $data))->toJson();

        // wp
        die();
    }

    /**
     * Add (return) bundle item.
     */
    public function addBundleItem()
    {
        if (! Guard::verifyAjaxNonce('cuztom', 'security')) {
            return;
        }

        $count = self::$request->get('count');
        $index = self::$request->get('index');
        $field = self::getField();

        $data = (new BundleItem(Cuztom::merge(
            $field->original,
            array(
                'parent' => $field,
                'index'  => $index
            )
        )))->output();

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
    public static function getField()
    {
        $field = self::$request->get('field');

        return Cuztom::getField($field);
    }
}
