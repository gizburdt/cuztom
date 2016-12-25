<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class User extends Meta
{
    /**
     * Locations.
     * @var array
     */
    public $locations;

    /**
     * Meta type.
     * @var string
     */
    public $meta_type = 'user';

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
        if (@$this->callback[0] == $this) {
            add_action('personal_options_update', array(&$this, 'saveUser'));
            add_action('edit_user_profile_update', array(&$this, 'saveUser'));
            add_action('user_edit_form_tag', array(&$this, 'editFormTag'));
        }

        foreach ($this->locations as $location) {
            add_action($location, $this->callback);
        }
    }

    /**
     * Callback for user meta, adds a title.
     *
     * @since 1.5
     */
    public function output()
    {
        echo '<h3>'.$this->title.'</h3>';

        parent::output();
    }

    /**
     * Hooks into the save hook for the user meta.
     *
     * @param int $id
     * @since 1.5
     */
    public function saveUser($id)
    {
        // Verify nonce
        if (! Guard::verifyNonce('cuztom_nonce', 'cuztom_meta')) {
            return;
        }

        $values = isset($_POST['cuztom'])
            ? $_POST['cuztom']
            : null;

        // Call parent save
        parent::save($id, $values);
    }

    /**
     * Get object ID.
     *
     * @return int|null
     * @since  3.0
     */
    public function determineObject()
    {
        return isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : get_current_user_id();
    }

    /**
     * Get value bases on field id.
     *
     * @return mixed
     * @since  3.0
     */
    public function getMetaValues()
    {
        return get_user_meta($this->object, true);
    }
}
