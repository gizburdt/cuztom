<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class YesNo extends Field
{
    use Checkable;

    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'radio';

    /**
     * View name.
     * @var string
     */
    protected $_view = 'yes-no';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-radio';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-yesno';
}
