<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Tabs;

Guard::directAccess();

class Accordion extends Tabs
{
    /**
     * Ouput accordion row
     * @param mixed $value
     * @since 3.0
     */
    public function output_row($value = null)
    {
        echo '<tr class="cuztom-accordion">';
        echo '<td class="cuztom-field" colspan="2" ' . $this->output_id() . '>';
        $this->output();
        echo '</td>';
        echo '</tr>';
    }

    /**
     * Output accordion
     * @param array  $args
     * @since 3.0
     */
    public function output($args = array())
    {
        $tabs         = $this->tabs;
        $args['type'] = 'accordion';

        echo '<div class="js-cztm-accordion">';
        foreach ($tabs as $title => $tab) {
            $tab->output($args);
        }
        echo '</div>';
    }
}
