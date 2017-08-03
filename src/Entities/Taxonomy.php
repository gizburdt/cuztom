<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Meta\Term as TermMeta;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Taxonomy extends Entity
{
    /**
     * Attached post type(s).
     * @var string|array
     */
    public $postType;

    /**
     * Constructs the class with important vars and method calls.
     * If the Taxonomy exists, it will be attached to the Post Type.
     *
     * @param string       $name
     * @param string|array $postType
     * @param array        $args
     */
    public function __construct($name, $postType = null, $args = array())
    {
        // Entity construct
        parent::__construct($name, $args);

        // Set properties
        $this->postType = (array) $postType;

        // Register taxonomy
        if (! taxonomy_exists($this->name)) {
            $this->registerEntity();
        } else {
            $this->registerEntityForObjectType();
        }

        // Hooks
        $this->addHooks();

        // Do
        do_action('cuztom_taxonomy_init');
    }

    /**
     * Add hooks.
     */
    public function addHooks()
    {
        if (isset($this->original['admin_column_sortable']) && $this->original['admin_column_sortable']) {
            foreach ($this->postType as $postType) {
                add_action("manage_edit-{$postType}_sortable_columns", array($this, 'addSortableColumn'));
            }
        }

        // Column filter
        if (isset($this->original['admin_column_filter']) && $this->original['admin_column_filter']) {
            add_action('restrict_manage_posts', array($this, 'adminColumnFilter'));
            add_filter('parse_query', array($this, 'postFilterQuery'));
        }

        // Do
        do_action('cuztom_taxonomy_hooks');
    }

    /**
     * Registers the custom Taxonomy with the given arguments.
     *
     * @return void
     */
    public function registerEntity()
    {
        parent::registerEntity();

        // Args
        $args = apply_filters('cuztom_taxonomy_args', array_merge(
            array(
                'label'             => sprintf(__('%s', 'cuztom'), $this->plural),
                'hierarchical'      => true,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                '_builtin'          => false,
                'show_admin_column' => false,
                'labels'            => array(
                    'name'              => sprintf(_x('%s', 'taxonomy general name', 'cuztom'), $this->plural),
                    'singular_name'     => sprintf(_x('%s', 'taxonomy singular name', 'cuztom'), $this->title),
                    'search_items'      => sprintf(__('Search %s', 'cuztom'), $this->plural),
                    'all_items'         => sprintf(__('All %s', 'cuztom'), $this->plural),
                    'parent_item'       => sprintf(__('Parent %s', 'cuztom'), $this->title),
                    'parent_item_colon' => sprintf(__('Parent %s:', 'cuztom'), $this->title),
                    'edit_item'         => sprintf(__('Edit %s', 'cuztom'), $this->title),
                    'update_item'       => sprintf(__('Update %s', 'cuztom'), $this->title),
                    'add_new_item'      => sprintf(__('Add New %s', 'cuztom'), $this->title),
                    'new_item_name'     => sprintf(__('New %s Name', 'cuztom'), $this->title),
                    'menu_name'         => sprintf(__('%s', 'cuztom'), $this->plural)
                ),
            ),
            $this->original
        ), $this);

        register_taxonomy($this->name, $this->postType, $args);
    }

    /**
     * Used to attach the existing Taxonomy to the Post Type.
     *
     * @return void
     */
    public function registerEntityForObjectType()
    {
        register_taxonomy_for_object_type($this->name, $this->postType);
    }

    /**
     * Add Term Meta to this Taxonomy.
     *
     * @param string $id
     * @param array  $data
     * @param array  $locations
     */
    public function addTermMeta($id, $data = array(), $locations = array('add_form', 'edit_form'))
    {
        $meta = new TermMeta($id, $this->name, $data, $locations);

        return $this;
    }

    /**
     * Add sortable column.
     *
     * @param array $columns
     */
    public function addSortableColumn($columns)
    {
        $columns["taxonomy-{$this->name}"] = $this->title;

        return $columns;
    }

    /**
     * Adds a filter to the post table filters.
     *
     * @return void
     */
    public function adminColumnFilter()
    {
        global $typenow, $wp_query;

        if (in_array($typenow, $this->postType)) {
            wp_dropdown_categories(array(
                'show_option_all' => sprintf(__('Show all %s', 'cuztom'), $this->plural),
                'taxonomy'        => $this->name,
                'name'            => $this->name,
                'orderby'         => 'name',
                'selected'        => isset($wp_query->query[$this->name]) ? $wp_query->query[$this->name] : '',
                'hierarchical'    => true,
                'show_count'      => true,
                'hide_empty'      => true,
            ));
        }
    }

    /**
     * Applies the selected filter to the query.
     *
     * @param  object $query
     * @return array
     */
    public function postFilterQuery($query)
    {
        // @TODO: Is this still right?
        global $pagenow;

        $vars = &$query->query_vars;

        if ($pagenow == 'edit.php' && isset($vars[$this->name]) && is_numeric($vars[$this->name]) && $vars[$this->name]) {
            $term = get_term_by('id', $vars[$this->name], $this->name);

            $vars[$this->name] = $term->slug;
        }

        return $vars;
    }
}
