<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Meta\Meta;

if (! defined('ABSPATH')) {
    exit;
}

class Term extends Meta
{
    public $meta_type      = 'term';
    public $taxonomies;
    public $locations;

    /**
     * Construct the term meta
     * @param string       $id
     * @param array        $data
     * @param string|array $taxonomy
     * @param array        $locations
     * @since 2.5
     */
    public function __construct($id, $taxonomy, $data = array(), $locations = array( 'add_form', 'edit_form' ))
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set taxonomy/locations
        $this->taxonomies   = (array) $taxonomy;
        $this->locations    = (array) $locations;

        // Build fields
        if (! $this->callback) {
            $this->callback = array( &$this, 'output' );

            // Build the meta box and fields
            $this->data = $this->build($this->fields);

            foreach ($this->taxonomies as $taxonomy) {
                if (in_array('add_form', $this->locations)) {
                    add_action($taxonomy . '_add_form_fields', array( &$this, 'add_form_fields' ));
                    add_action('created_' . $taxonomy, array( &$this, 'save_term' ));
                }

                if (in_array('edit_form', $this->locations)) {
                    add_action($taxonomy . '_edit_form_fields', array( &$this, 'edit_form_fields' ));
                    add_action('edited_' . $taxonomy, array( &$this, 'save_term' ));
                }

                add_filter('manage_edit-' . $taxonomy . '_columns', array( &$this, 'add_column' ));
                add_filter('manage_' . $taxonomy . '_custom_column', array( &$this, 'add_column_content' ), 10, 3);
            }
        }
    }

    /**
     * Add fields to the add term form
     * @param  string $taxonomy
     * @return mixed
     * @since  2.5
     */
    public function add_form_fields($taxonomy)
    {
        return $this->output();
    }

    /**
     * Add fields to the edit term form
     * @param  string $taxonomy
     * @return mixed
     * @since  2.5
     */
    public function edit_form_fields($taxonomy)
    {
        echo '</table>';

        return $this->output();
    }

    /**
     * Save the term
     * @param integer $term_id [description]
     * @since 2.5
     */
    public function save_term($term_id)
    {
        // Verify nonce
        if (! (isset($_POST['cuztom_nonce']) && wp_verify_nonce($_POST['cuztom_nonce'], 'cuztom_meta'))) {
            return;
        }

        $values = isset($_POST['cuztom']) ? $_POST['cuztom'] : null;

        if (! empty($values)) {
            parent::save($term_id, $values);
        }
    }

    /**
     * Used to add a column head to the Taxonomy's List Table
     * @param  array $columns
     * @return array
     * @since  1.1
     */
    public function add_column($columns)
    {
        foreach ($this->fields as $id => $field) {
            if ($field->show_admin_column) {
                $columns[$id] = $field->label;
            }
        }

        return $columns;
    }

    /**
     * Used to add the column content to the column head
     * @param string  $row
     * @param string  $column
     * @param integer $term_id
     * @since 1.1
     */
    public function add_column_content($row, $column, $term_id)
    {
        $screen = get_current_screen();

        if ($screen) {
            $taxonomy = $screen->taxonomy;

            $meta = get_term_meta($term_id, $column, true);

            foreach ($this->fields as $id => $field) {
                if ($column == $id) {
                    if ($field->repeatable && $field->_supports_repeatable) {
                        echo implode($meta, ', ');
                    } else {
                        if ($field instanceof Cuztom_Field_Image) {
                            echo wp_get_attachment_image($meta, array( 100, 100 ));
                        } else {
                            echo $meta;
                        }
                    }

                    break;
                }
            }
        }
    }

    /**
     * Get object ID
     * @return integer|null
     * @since  3.0
     */
    public function get_object_id()
    {
        if (isset($_GET['tag_ID'])) {
            return $_GET['tag_ID']; // @TODO: Use get_current_screen()
        }

        return null;
    }

    /**
     * Get value bases on field id
     * @return mixed
     * @since  3.0
     */
    public function get_meta_values()
    {
        return get_term_meta($this->object);
    }
}
