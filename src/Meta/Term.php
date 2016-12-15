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
    public $meta_type = 'term';

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
        if (@$this->callback[0] == $this) {
            foreach ($this->taxonomies as $taxonomy) {
                if (in_array('add_form', $this->locations)) {
                    add_action($taxonomy.'_add_form_fields', array(&$this, 'addFormFields'));
                    add_action('created_'.$taxonomy, array(&$this, 'saveTerm'));
                }

                if (in_array('edit_form', $this->locations)) {
                    add_action($taxonomy.'_edit_form_fields', array(&$this, 'editFormFields'));
                    add_action('edited_'.$taxonomy, array(&$this, 'saveTerm'));
                }

                add_filter('manage_edit-'.$taxonomy.'_columns', array(&$this, 'addColumn'));
                add_filter('manage_'.$taxonomy.'_custom_column', array(&$this, 'addColumnContent'), 10, 3);
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
    public function addFormFields($taxonomy)
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
    public function editFormFields($taxonomy)
    {
        echo '</table>';

        echo $this->output();
    }

    /**
     * Save the term.
     *
     * @param int $id
     * @since 2.5
     */
    public function saveTerm($id)
    {
        // Verify nonce
        if (! Guard::verifyNonce('cuztomNonce', 'cuztomMeta')) {
            return;
        }

        $values = isset($_POST['cuztom'])
            ? $_POST['cuztom']
            : null;

        // Call parent save
        parent::save($id, $values);
    }

    /**
     * Used to add a column head to the Taxonomy's List Table.
     *
     * @param  array $columns
     * @return array
     * @since  1.1
     */
    public function addColumn($columns)
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
    public function addColumnContent($row, $column, $term_id)
    {
        $field = $this->fields[$column];

        echo $field->outputColumnContent();
    }

    /**
     * Get object ID.
     *
     * @return int|null
     * @since  3.0
     */
    public function determineObject()
    {
        return isset($_REQUEST['tag_ID']) ? $_REQUEST['tag_ID'] : null;
    }

    /**
     * Get value bases on field id.
     *
     * @return mixed
     * @since  3.0
     */
    public function getMetaValues()
    {
        return get_term_meta($this->object);
    }
}
