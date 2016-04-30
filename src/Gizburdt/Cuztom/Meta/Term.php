<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Term extends Meta
{
    /**
     * Taxonomies.
     * @var array
     */
    public $taxonomies;

    /**
     * Locations.
     * @var array
     */
    public $locations;

    /**
     * Meta Type.
     * @var string
     */
    public $_meta_type = 'term';

    /**
     * Construct the term meta.
     *
     * @param string       $id
     * @param array        $data
     * @param string|array $taxonomy
     * @param array        $locations
     * @since 2.5
     */
    public function __construct($id, $taxonomy, $data = array(), $locations = array('edit_form'))
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set taxonomy/locations
        $this->taxonomies   = (array) $taxonomy;
        $this->locations    = (array) $locations;

        // Build fields
        if (! $this->callback) {
            foreach ($this->taxonomies as $taxonomy) {
                if (in_array('add_form', $this->locations)) {
                    add_action($taxonomy.'_add_form_fields', array(&$this, 'add_form_fields'));
                    add_action('created_'.$taxonomy, array(&$this, 'save_term'));
                }

                if (in_array('edit_form', $this->locations)) {
                    add_action($taxonomy.'_edit_form_fields', array(&$this, 'edit_form_fields'));
                    add_action('edited_'.$taxonomy, array(&$this, 'save_term'));
                }

                add_filter('manage_edit-'.$taxonomy.'_columns', array(&$this, 'add_column'));
                add_filter('manage_'.$taxonomy.'_custom_column', array(&$this, 'add_column_content'), 10, 3);
            }
        }
    }

    /**
     * Add fields to the add term form.
     *
     * @param  string $taxonomy
     * @return mixed
     * @since  2.5
     */
    public function add_form_fields($taxonomy)
    {
        echo $this->output();
    }

    /**
     * Add fields to the edit term form.
     *
     * @param  string $taxonomy
     * @return mixed
     * @since  2.5
     */
    public function edit_form_fields($taxonomy)
    {
        echo '</table>';

        echo $this->output();
    }

    /**
     * Save the term.
     *
     * @param int $term_id
     * @since 2.5
     */
    public function save_term($term_id)
    {
        // Verify nonce
        if (! Guard::verifyNonce('cuztom_nonce', 'cuztom_meta')) {
            return;
        }

        $values = isset($_POST['cuztom']) ? $_POST['cuztom'] : null;

        if (! Cuztom::is_empty($values)) {
            parent::save($term_id, $values);
        }
    }

    /**
     * Used to add a column head to the Taxonomy's List Table.
     *
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
     * Used to add the column content to the column head.
     *
     * @param string $row
     * @param string $column
     * @param int    $term_id
     * @since 1.1
     */
    public function add_column_content($row, $column, $term_id)
    {
        $field = $this->fields[$column];

        echo $field->output_column_content($term_id);
    }

    /**
     * Get object ID.
     *
     * @return int|null
     * @since  3.0
     */
    public function determine_object()
    {
        return isset($_GET['tag_ID']) ? $_GET['tag_ID'] : null;
    }

    /**
     * Get value bases on field id.
     *
     * @return mixed
     * @since  3.0
     */
    public function get_meta_values()
    {
        return get_term_meta($this->_object);
    }
}
