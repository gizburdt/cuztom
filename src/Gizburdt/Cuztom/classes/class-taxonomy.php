<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Taxonomy extends Cuztom_Entity
{
    /**
     * Taxonomy's args
     * @var array
     */
    var $args;

    /**
     * Labels
     * @var array
     */
    var $labels;

    /**
     * Attached post type
     * @var string|array
     */
    var $post_type;

    /**
     * Constructs the class with important vars and method calls
     * If the taxonomy exists, it will be attached to the post type
     *
     * @param string|array $name
     * @param string       $post_type
     * @param array        $args
     * @param array        $labels
     * @since 0.2
     */
    function __construct( $name, $post_type = null, $args = array(), $labels = array() )
    {
        // Entity construct
        parent::__construct($name);

        // Set properties
        $this->post_type    = (array) $post_type;
        $this->labels       = $labels;
        $this->args         = $args;

        // Register taxonomy
        if( ! taxonomy_exists( $this->name ) ) {
            $this->register_taxonomy();
        } else {
            $this->register_taxonomy_for_object_type();
        }

        // Sortable columns
        if( @$args['admin_column_sortable'] ) {
            foreach($this->post_type as $post_type) {
                add_action( "manage_edit-{$post_type}_sortable_columns", array( &$this, 'add_sortable_column' ) );
            }
        }

        // Column filter
        if( @$args['admin_column_filter'] ) {
            add_action( 'restrict_manage_posts', array( &$this, 'admin_column_filter' ) );
            add_filter( 'parse_query', array( &$this, '_post_filter_query') );
        }
    }

    /**
     * Registers the custom taxonomy with the given arguments
     *
     * @since 0.2
     */
    function register_taxonomy()
    {
        if( $reserved = Cuztom::is_reserved_term( $this->name ) ) {
            new Cuztom_Notice( $reserved->get_error_message(), 'error' );
        } else {
            $labels = array_merge(
                array(
                    'name'                  => sprintf( _x( '%s', 'taxonomy general name', 'cuztom' ), $this->plural ),
                    'singular_name'         => sprintf( _x( '%s', 'taxonomy singular name', 'cuztom' ), $this->title ),
                    'search_items'          => sprintf( __( 'Search %s', 'cuztom' ), $this->plural ),
                    'all_items'             => sprintf( __( 'All %s', 'cuztom' ), $this->plural ),
                    'parent_item'           => sprintf( __( 'Parent %s', 'cuztom' ), $this->title ),
                    'parent_item_colon'     => sprintf( __( 'Parent %s:', 'cuztom' ), $this->title ),
                    'edit_item'             => sprintf( __( 'Edit %s', 'cuztom' ), $this->title ),
                    'update_item'           => sprintf( __( 'Update %s', 'cuztom' ), $this->title ),
                    'add_new_item'          => sprintf( __( 'Add New %s', 'cuztom' ), $this->title ),
                    'new_item_name'         => sprintf( __( 'New %s Name', 'cuztom' ), $this->title ),
                    'menu_name'             => sprintf( __( '%s', 'cuztom' ), $this->plural )
                ),
                $this->labels
            );

            $args = array_merge(
                array(
                    'label'                 => sprintf( __( '%s', 'cuztom' ), $this->plural ),
                    'labels'                => $labels,
                    'hierarchical'          => true,
                    'public'                => true,
                    'show_ui'               => true,
                    'show_in_nav_menus'     => true,
                    '_builtin'              => false,
                    'show_admin_column'     => false
                ),
                $this->args
            );

            register_taxonomy( $this->name, $this->post_type, $args );
        }
    }

    /**
     * Used to attach the existing taxonomy to the post type
     *
     * @since 0.2
     */
    function register_taxonomy_for_object_type()
    {
        register_taxonomy_for_object_type( $this->name, $this->post_type );
    }

    /**
     * Add term meta to this taxonomy
     *
     * @param integer $id
     * @param array   $data
     * @param array   $locations
     * @since 2.5
     */
    function add_term_meta( $id, $data = array(), $locations = array( 'add_form', 'edit_form' ) )
    {
        $term_meta = new Cuztom_Term_Meta( $id, $data, $this->name, $locations );

        return $this;
    }

    /**
     * Used to make all columns sortable
     *
     * @param array $columns
     * @since 1.6
     */
    function add_sortable_column( $columns )
    {
        $columns["taxonomy-{$this->name}"] = $this->title;

        return $columns;
    }

    /**
     * Adds a filter to the post table filters
     *
     * @since 1.6
     */
    function admin_column_filter()
    {
        global $typenow, $wp_query;

        if( in_array($typenow, $this->post_type) ) {
            wp_dropdown_categories( array(
                'show_option_all'   => sprintf( __( 'Show all %s', 'cuztom' ), $this->plural ),
                'taxonomy'          => $this->name,
                'name'              => $this->name,
                'orderby'           => 'name',
                'selected'          => isset( $wp_query->query[$this->name] ) ? $wp_query->query[$this->name] : '',
                'hierarchical'      => true,
                'show_count'        => true,
                'hide_empty'        => true,
            ) );
        }
    }

    /**
     * Applies the selected filter to the query
     *
     * @param  object $query
     * @return array
     * @since  1.6
     */
    function _post_filter_query($query)
    {
        // @TODO: Is this still right?
        global $pagenow;
        $vars = &$query->query_vars;

        if( $pagenow == 'edit.php' && isset( $vars[$this->name] ) && is_numeric( $vars[$this->name] ) && $vars[$this->name] ) {
            $term = get_term_by( 'id', $vars[$this->name], $this->name );
            $vars[$this->name] = $term->slug;
        }

        return $vars;
    }
}