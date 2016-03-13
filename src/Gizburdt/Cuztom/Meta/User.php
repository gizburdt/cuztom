<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class User extends Meta
{
    /**
     * Meta type.
     * @var string
     */
    public $meta_type = 'user';

    /**
     * Locations.
     * @var array
     */
    public $locations;

    /**
     * Constructor for User Meta.
     *
     * @param string       $id
     * @param array        $data
     * @param string|array $locations
     * @since 1.5
     */
    public function __construct($id, $data = array(), $locations = array('show_user_profile', 'edit_user_profile'))
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set locations
        $this->locations = (array) $locations;

        // Chack if the class, function or method exist, otherwise use cuztom callback
        if (! $this->callback) {
            $this->callback = array(&$this, 'output');

            // Build the meta box and fields
            $this->data = $this->build($this->fields);

            add_action('personal_options_update', array(&$this, 'save_user'));
            add_action('edit_user_profile_update', array(&$this, 'save_user'));
            add_action('user_edit_form_tag', array(&$this, 'edit_form_tag'));
        }

        foreach ($this->locations as $location) {
            add_action($location, $this->callback);
        }
    }

    /**
     * Callback for user meta, adds a title.
     *
     * @param int   $user
     * @param array $data
     * @param array $args
     * @since 1.5
     */
    public function output($user, $data = array(), $args = array())
    {
        echo '<h3>' . $this->title . '</h3>';

        parent::output($user, $this->data, $args);
    }

    /**
     * Hooks into the save hook for the user meta.
     *
     * @param integer $user_id
     * @since 1.5
     */
    public function save_user($user_id)
    {
        // Verify nonce
        if (! (isset($_POST['cuztom_nonce']) && wp_verify_nonce($_POST['cuztom_nonce'], 'cuztom_meta'))) {
            return;
        }

        $values = isset($_POST['cuztom']) ? $_POST['cuztom'] : null;

        if (! Cuztom::is_empty($values)) {
            parent::save($user_id, $values);
        }
    }

    /**
     * Get object ID.
     *
     * @return int|null
     * @since  3.0
     */
    public function get_object_id()
    {
        if (isset($_GET['user_id'])) {
            return $_GET['user_id']; // @TODO: Use get_current_screen()
        }

        return null;
    }

    /**
     * Get value bases on field id.
     *
     * @return mixed
     * @since  3.0
     */
    public function get_meta_values()
    {
        return get_user_meta($this->object);
    }
}
