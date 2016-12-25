<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class TermCheckboxes extends Checkboxes
{
    /**
     * Base.
     * @var mixed
     */
    public $view = 'term-checkboxes';

    /**
     * Fillables.
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--term-checkboxes';

    /**
     * Terms.
     * @var array
     */
    public $terms;

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->args = array_merge(
            array(
                'taxonomy' => 'category'
            ),
            $this->args
        );

        $this->terms         = get_terms($this->args['taxonomy'], $this->args);
        $this->default_value = (array) $this->default_value;
    }
}
