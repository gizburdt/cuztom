<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class TaxonomySelect extends Select
{
    /**
     * View name.
     * @var string
     */
    public $view = 'taxonomy-select';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select cuztom-input-taxonomy-select';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-taxonomy-select';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
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
