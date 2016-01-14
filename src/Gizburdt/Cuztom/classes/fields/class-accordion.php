<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion extends Cuztom_Tabs
{
    /**
     * Ouput accordion row
     * @param mixed $value
     * @since 3.0
     */
    function output_row( $value = null )
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
    function output( $args = array() )
    {
        $tabs         = $this->tabs;
        $args['type'] = 'accordion';

        echo '<div class="js-cztm-accordion">';
            foreach( $tabs as $title => $tab ) {
                $tab->output($args);
            }
        echo '</div>';
    }
}