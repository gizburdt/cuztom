<?php

namespace Gizburdt\Cuztom\Entities;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Meta\Term as TermMeta;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Notice;

Guard::directAccess();

class Taxonomy extends Entity
{
    /**
     * Args.
     * @var array
     */
    public $args;

    /**
     * Labels.
     * @var array
     */
    public $labels;

    /**
     * Attached post type.
     * @var string|array
     */
    public $post_type;

    /**
     * Constructs the class with important vars and method calls.
     * If the taxonomy exists, it will be attached to the post type.
     *
     * @param string       $name
     * @param string|array $post_type
     * @param array        $args
     * @since 0.2
     */
    public function __construct($name, $post_type = null, $args = array())
    {
        // Entity construct
        parent::__construct($name, $args);

        // Set properties
        $this->post_type = (array) $post_type;

        // Register taxonomy
        if (! taxonomy_exists($this->name)) {
            $this->registerTaxonomy();
        } else {
            $this->registerTaxonomyForObjectType();
        }

        // Sortable columns
        if (@$args['admin_column_sortable']) {
            foreach ($this->post_type as $post_type) {
                add_action("manage_edit-{$post_type}_sortable_columns", array(&$this, 'addSortableColumn'));
            }
        }

        // Column filter
        if (@$args['admin_column_filter']) {
            add_action('restrict_manage_posts', array(&$this, 'adminColumnFilter'));
            add_filter('parse_query', array(&$this, '_postFilterQuery'));
        }
    }

    /**
     * Registers the custom taxonomy with the given arguments.
     *
     * @since 0.2
     */
    public function registerTaxonomy()
    {
        if ($reserved = Cuztom::isReservedTerm($this->name)) {
            return new Notice($reserved->get_error_message(), 'error');
        }

        $args = array_merge(
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
        );

        register_taxonomy($this->name, $this->post_type, $args);
    }

    /**
     * Used to attach the existing taxonomy to the post type.
     *
     * @since 0.2
     */
    public function registerTaxonomyForObjectType()
    {
        register_taxonomy_for_object_type($this->name, $this->post_type);
    }

    /**
     * Add term meta to this taxonomy.
     *
     * @param int   $id
     * @param array $data
     * @param array $locations
     * @since 2.5
     */
    public function addTermMeta($id, $data = array(), $locations = array('add_form', 'edit_form'))
    {
        $meta = new TermMeta($id, $this->name, $data, $locations);

        return $this;
    }

    /**
     * Used to make all columns sortable.
     *
     * @param array $columns
     * @since 1.6
     */
    public function addSortableColumn($columns)
    {
        $columns["taxonomy-{$this->name}"] = $this->title;

        return $columns;
    }

    /**
     * Adds a filter to the post table filters.
     *
     * @since 1.6
     */
    public function adminColumnFilter()
    {
        global $typenow, $wp_query;

        if (in_array($typenow, $this->post_type)) {
            wp_dropdown_categories(array(
                'show_option_all'   => sprintf(__('Show all %s', 'cuztom'), $this->plural),
                'taxonomy'          => $this->name,
                'name'              => $this->name,
                'orderby'           => 'name',
                'selected'          => isset($wp_query->query[$this->name]) ? $wp_query->query[$this->name] : '',
                'hierarchical'      => true,
                'show_count'        => true,
                'hide_empty'        => true,
            ));
        }
    }

    /**
     * Applies the selected filter to the query.
     *
     * @param  object $query
     * @return array
     * @since  1.6
     */
    public function _postFilterQuery($query)
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
