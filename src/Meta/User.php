<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Request;

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
    public $metaType = 'user';

    /**
     * Constructor for User Meta.
     *
     * @param string       $id
     * @param array        $data
     * @param string|array $locations
     */
    public function __construct($id, $data = array(), $locations = array('show_user_profile', 'edit_user_profile'))
    {
        // Build all properties
        parent::__construct($id, $data);

        // Set locations
        $this->locations = (array) $locations;

        // Hooks
        $this->addHooks();
    }

    /**
     * Add hooks.
     */
    public function addHooks()
    {
        if (isset($this->callback[0]) && $this->callback[0] == $this) {
            add_action('personal_options_update', array(&$this, 'saveUser'));
            add_action('edit_user_profile_update', array(&$this, 'saveUser'));
            add_action('user_edit_form_tag', array(&$this, 'editFormTag'));
        }

        // Add forms to locations
        foreach ($this->locations as $location) {
            add_action($location, $this->callback);
        }
    }

    /**
     * Callback for user meta, adds a title.
     *
     * @return void
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
     */
    public function saveUser($id)
    {
        if (! Guard::verifyNonce('cuztom_nonce', 'cuztom_meta')) {
            return;
        }

        $values = (new Request($_POST))->getAll();

        parent::save($id, $values);
    }

    /**
     * Get object ID.
     *
     * @return int|null
     */
    public function determineObject()
    {
        if (isset($_REQUEST['user_id'])) {
            return $_REQUEST['user_id'];
        } elseif (! isset($_POST['cuztom']['object'])) {
            return get_current_user_id();
        } elseif ($_POST['cuztom']['object']) {
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
        return get_user_meta($this->object);
    }
}
