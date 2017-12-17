<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Meta\Box as MetaBox;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class PostType extends Entity
{
    /**
     * Construct a new Cuztom Post Type.
     *
     * @param string $name
     * @param array  $args
     */
    public function __construct($name, $args = array())
    {
        // Entity construct
        parent::__construct($name, $args);

        // Register
        if (! post_type_exists($this->name)) {
            $this->registerEntity();
        }

        // Do
        do_action('cuztom_post_type');
    }

    /**
     * Register post Type.
     *
     * @return void
     */
    public function registerEntity()
    {
        parent::registerEntity();

        // Args
        $args = apply_filters('cuztom_post_type_args', array_merge(
            array(
                'label'       => sprintf(__('%s', 'cuztom'), $this->plural),
                'public'      => true,
                'supports'    => array('title', 'editor'),
                'has_archive' => sanitize_title($this->plural),
                'labels'      => array(
                    'name'               => sprintf(_x('%s', 'post type general name', 'cuztom'), $this->plural),
                    'singular_name'      => sprintf(_x('%s', 'post type singular title', 'cuztom'), $this->title),
                    'menu_name'          => sprintf(__('%s', 'cuztom'), $this->plural),
                    'all_items'          => sprintf(__('All %s', 'cuztom'), $this->plural),
                    'add_new'            => sprintf(_x('Add New', '%s', 'cuztom'), $this->title),
                    'add_new_item'       => sprintf(__('Add New %s', 'cuztom'), $this->title),
                    'edit_item'          => sprintf(__('Edit %s', 'cuztom'), $this->title),
                    'new_item'           => sprintf(__('New %s', 'cuztom'), $this->title),
                    'view_item'          => sprintf(__('View %s', 'cuztom'), $this->title),
                    'items_archive'      => sprintf(__('%s Archive', 'cuztom'), $this->title),
                    'search_items'       => sprintf(__('Search %s', 'cuztom'), $this->plural),
                    'not_found'          => sprintf(__('No %s found', 'cuztom'), $this->plural),
                    'not_found_in_trash' => sprintf(__('No %s found in trash', 'cuztom'), $this->plural),
                    'parent_item_colon'  => sprintf(__('%s Parent', 'cuztom'), $this->title),
                ),
            ),
            $this->original
        ), $this);

        // Register the post type
        register_post_type($this->name, $args);
    }

    /**
     * Add a taxonomy to the Post Type.
     *
     * @param string|array $name
     * @param array        $args
     */
    public function addTaxonomy($name, $args = array())
    {
        $taxonomy = new Taxonomy($name, $this->name, $args);

        return $this;
    }

    /**
     * Add Meta Box to the Post Type.
     *
     * @param string $id
     * @param array  $args
     */
    public function addMetaBox($id, $args)
    {
        $box = new MetaBox($id, $this->name, $args);

        return $this;
    }

    /**
     * Add support to Post Type.
     *
     * @param  string|array $feature
     * @return object
     */
    public function addPostTypeSupport($feature)
    {
        add_post_type_support($this->name, $feature);

        return $this;
    }

    /**
     * Remove support from Post Type.
     *
     * @param  string|array $feature
     * @return object
     */
    public function removePostTypeSupport($features)
    {
        foreach ((array) $features as $feature) {
            remove_post_type_support($this->name, $feature);
        }

        return $this;
    }

    /**
     * Check if post type supports a certain feature.
     *
     * @param  string|array $feature
     * @return bool
     */
    public function postTypeSupports($feature)
    {
        return post_type_supports($this->name, $feature);
    }
}
