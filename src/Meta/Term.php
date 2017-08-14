<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Request;

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
    public $metaType = 'term';

    /**
     * Construct the term meta.
     *
     * @param string       $id
     * @param string|array $taxonomy
     * @param array        $data
     * @param array        $locations
     */
    public function __construct($id, $taxonomy, $data = array(), $locations = array('edit_form'))
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set taxonomy/locations
        $this->taxonomies = (array) $taxonomy;
        $this->locations  = (array) $locations;

        // Hooks
        $this->addHooks();

        // Do
        do_action('cuztom_term_init', $this);
    }

    /**
     * Add hooks.
     */
    public function addHooks()
    {
        if (isset($this->callback[0]) && $this->callback[0] == $this) {
            foreach ($this->taxonomies as $taxonomy) {
                if (in_array('add_form', $this->locations)) {
                    add_action($taxonomy.'_add_form_fields', array($this, 'addFormFields'));
                    add_action('created_'.$taxonomy, array($this, 'saveTerm'));
                }

                if (in_array('edit_form', $this->locations)) {
                    add_action($taxonomy.'_edit_form_fields', array($this, 'editFormFields'));
                    add_action('edited_'.$taxonomy, array($this, 'saveTerm'));
                }

                add_filter('manage_edit-'.$taxonomy.'_columns', array($this, 'addColumn'));
                add_filter('manage_'.$taxonomy.'_custom_column', array($this, 'addColumnContent'), 10, 3);
            }
        }

        // Do
        do_action('cuztom_term_hooks', $this);
    }

    /**
     * Add fields to the add term form.
     *
     * @param  string $taxonomy
     * @return mixed
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
     */
    public function saveTerm($id)
    {
        if (! Guard::verifyNonce('cuztom_nonce', 'cuztom_meta')) {
            return;
        }

        // Filter
        $values = apply_filters('cuztom_term_save_values', (new Request($_POST))->getAll(), $this);

        // Do
        do_action('cuztom_term_save', $this);

        parent::save($id, $values);
    }

    /**
     * Used to add a column head to the Taxonomy's List Table.
     *
     * @param  array $columns
     * @return array
     */
    public function addColumn($columns)
    {
        foreach ($this->fields as $id => $field) {
            if (isset($field->show_admin_column) && $field->show_admin_column) {
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
     * @param int    $termId
     */
    public function addColumnContent($row, $column, $termId)
    {
        if (isset($this->fields[$column]) && $field = $this->fields[$column]) {
            echo $field->outputColumnContent();
        } else {
            return $row;
        }
    }

    /**
     * Get object ID.
     *
     * @return int|null
     */
    public function determineObject()
    {
        if (isset($_REQUEST['tag_ID'])) {
            return $_REQUEST['tag_ID'];
        }

        if (isset($_POST['cuztom']['object'])) {
            return $_POST['cuztom']['object'];
        }
    }

    /**
     * Get value bases on field id.
     *
     * @return mixed
     */
    public function getMetaValues()
    {
        return apply_filters('cuztom_term_values', get_term_meta($this->object), $this);
    }
}
