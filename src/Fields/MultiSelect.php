<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class MultiSelect extends Select
{
    use Selectable;

    /**
     * Base.
     * @var mixed
     */
    public $view = 'multi-select';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--select cuztom-input--multi-select';
    public $cell_css_class = 'cuztom-field--multi-select';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->afterName .= '[]';

        $this->args['multiselect'] = true;
    }
}
