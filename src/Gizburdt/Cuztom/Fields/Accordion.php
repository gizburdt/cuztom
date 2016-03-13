<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Accordion extends Tabs
{
    /**
     * Ouput accordion row.
     *
     * @param mixed $value
     * @since 3.0
     */
    public function output_row($value = null)
    {
        Cuztom::view('fields/row/accordion', array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Output accordion.
     *
     * @param array $args
     * @since 3.0
     */
    public function output($args = array())
    {
        $args['type'] = 'accordion';

        Cuztom::view('fields/accordion', array(
            'field' => $this,
            'args'  => $args
        ));
    }
}
