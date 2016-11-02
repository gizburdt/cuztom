<?php

namespace Gizburdt\Cuztom\Support;

Guard::directAccess();

class Notice
{
    /**
     * Notice itself.
     * @var string
     */
    public $notice;

    /**
     * Type.
     * @var string
     */
    public $type;

    /**
     * Dismissible?
     * @var bool
     */
    public $dismissible;

    /**
     * Constructor.
     *
     * @param string $notice
     * @param string $type
     * @param bool   $dismissible
     * @since 2.3
     */
    public function __construct($notice, $type, $dismissible = true)
    {
        $this->notice      = $notice;
        $this->type        = $type ? $type : 'updated';
        $this->dismissible = $dismissible;

        add_action('admin_notices', array(&$this, 'addAdminNotice'));
    }

    /**
     * Adds the admin notice.
     *
     * @since 2.3
     */
    public function addAdminNotice()
    {
        echo '<div class="'.$this->getCssClass().'"><p>'.$this->notice.'</p></div>';
    }

    /**
     * Returns the complete css class for the notice.
     *
     * @return string
     * @since  2.3
     */
    public function getCssClass()
    {
        return $this->type.($this->dismissible ? ' is-dismissible' : '');
    }
}
