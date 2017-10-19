<?php

namespace Gizburdt\Cuztom;

Guard::blockDirectAccess();

class Notice
{
    /**
     * Constructor.
     *
     * @param string $notice
     * @param string $type
     * @param bool   $dismissible
     */
    public function __construct($notice, $type, $dismissible = true)
    {
        $class = $type.($dismissible ? ' is-dismissible' : '');

        add_action('admin_notices', function () use ($class, $notice) {
            echo '<div class="'.$class.'"><p>'.$notice.'</p></div>';
        });
    }
}
