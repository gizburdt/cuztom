<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkables;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkboxes extends Field
{
    use Checkables;

    /**
     * Css class.
     * @var string
     */
    public $input_type = 'checkbox';

    /**
     * View name.
     * @var string
     */
    public $view = 'checkboxes';

    /**
     * Css class.
     * @var string
     */
    public $css_class = 'cuztom-input-checkbox';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-checkboxes';

    /**
     * Construct.
     *
     * @param array $args
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($field, $values);

        $this->default_value = (array) $this->default_value;
        $this->after_name   .= '[]';
    }
}
