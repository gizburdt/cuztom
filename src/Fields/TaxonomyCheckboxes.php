<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Guard;
use Gizburdt\Cuztom\Cuztom;

Guard::blockDirectAccess();

class TaxonomyCheckboxes extends Checkboxes
{
    /**
     * Base.
     *
     * @var mixed
     */
    public $view = 'taxonomy-checkboxes';

    /**
     * Fillables.
     *
     * @var mixed
     */
    public $cell_css_class = 'cuztom-field--taxonomy-checkboxes';

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
            [
                'public' => true,
            ],
            $this->args
        );

        $this->taxonomies = get_taxonomies($this->args, 'objects');
    }
}
