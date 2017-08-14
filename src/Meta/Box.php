<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Request;

Guard::directAccess();

class Box extends Meta
{
    /**
     * Context.
     * @var string
     */
    public $context = 'normal';

    /**
     * Priority.
     * @var string
     */
    public $priority = 'default';

    /**
     * Post types.
     * @var string|array
     */
    public $postTypes;

    /**
     * Meta type.
     * @var string
     */
    public $metaType = 'post';

    /**
     * Constructs the meta box.
     *
     * @param string       $id
     * @param array        $data
     * @param string|array $post_type
     */
    public function __construct($id, $postType, $data = array())
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set post types
        $this->postTypes = (array) $postType;

        // Hooks
        $this->addHooks();

        // Do
        do_action('cuztom_box_init', $this);
    }

    /**
     * Add all hooks.
     */
    public function addHooks()
    {
        if (isset($this->callback[0]) && $this->callback[0] == $this) {
            foreach ($this->postTypes as $postType) {
                add_filter('manage_'.$postType.'_posts_columns', array($this, 'addColumn'));
                add_action('manage_'.$postType.'_posts_custom_column', array($this, 'addColumnContent'), 10, 2);
                add_action('manage_edit-'.$postType.'_sortable_columns', array($this, 'addSortableColumn'), 10, 2);
            }

            add_action('save_post', array($this, 'savePost'));
            add_action('post_edit_form_tag', array($this, 'editFormTag'));
        }

        // Add the meta box
        add_action('add_meta_boxes', array($this, 'addMetaBox'));

        // Do
        do_action('cuztom_box_hooks', $this);
    }

    /**
     * Method that calls the add_meta_box function.
     */
    public function addMetaBox()
    {
        foreach ($this->postTypes as $postType) {
            add_meta_box(
                $this->id,
                $this->title,
                $this->callback,
                $postType,
                $this->context,
                $this->priority
            );
        }
    }

    /**
     * Hooks into the save hook for the newly registered Post Type.
     *
     * @param int $id
     */
    public function savePost($id)
    {
        if (
            Guard::doingAutosave() ||
            Guard::doingAjax() ||
            ! Guard::verifyNonce('cuztom_nonce', 'cuztom_meta') ||
            ! Guard::isPostType($id, $this->postTypes) ||
            ! Guard::userCanEdit($id)
        ) {
            return;
        }

        // Filter
        $values = apply_filters('cuztom_box_save_values', (new Request($_POST))->getAll(), $this);

        // Do
        do_action('cuztom_box_save', $this);

        parent::save($id, $values);
    }

    /**
     * Used to add a column head to the Post Type's List Table.
     *
     * @param  array $columns
     * @return array
     */
    public function addColumn($columns)
    {
        unset($columns['date']);

        foreach ($this->data as $id => $field) {
            if (isset($field->show_admin_column) && $field->show_admin_column) {
                $columns[$id] = $field->label;
            }
        }

        $columns['date'] = __('Date');

        return $columns;
    }

    /**
     * Used to add the column content to the column head.
     *
     * @param string $column
     * @param int    $postId
     */
    public function addColumnContent($column, $postId)
    {
        if (isset($this->data[$column]) && $field = $this->data[$column]) {
            echo $field->outputColumnContent($postId);
        } else {
            return $column;
        }
    }

    /**
     * Used to make all columns sortable.
     *
     * @param  array $columns
     * @return array
     */
    public function addSortableColumn($columns)
    {
        if ($this->data) {
            foreach ($this->data as $id => $field) {
                if ($field->admin_column_sortable) {
                    $columns[$id] = $field->label;
                }
            }
        }

        return $columns;
    }

    /**
     * Get object ID.
     *
     * @return int|null
     */
    public function determineObject()
    {
        if (isset($_GET['post'])) {
            return $_GET['post'];
        }

        if (isset($_POST['post_ID'])) {
            return $_POST['post_ID'];
        }

        if (isset($_POST['cuztom']['object'])) {
            return $_POST['cuztom']['object'];
        }
    }

    /**
     * Get value bases on field id.
     *
     * @return array
     */
    public function getMetaValues()
    {
        return apply_filters('cuztom_box_values', get_post_meta($this->object), $this);
    }
}
