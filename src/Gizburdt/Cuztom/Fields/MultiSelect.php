<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class MultiSelect extends Field
{
    use Selectable;

    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-select cuztom-multi-select';

    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->after_name          .= '[]';
        $this->args['multiselect']  = true;
    }
}
