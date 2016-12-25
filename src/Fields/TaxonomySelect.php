<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class TaxonomySelect extends Select
{
    /**
     * Base.
     * @var mixed
     */
    public $view = 'taxonomy-select';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--select cuztom-input--taxonomy-select';
    public $cell_css_class = 'cuztom-field--taxonomy-select';

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
                'public' => true,
            ),
            $this->args
        );

        $this->taxonomies = get_taxonomies($this->args, 'objects');
    }
}
