<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class File extends Field
{
    /**
     * Input type.
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * View name.
     * @var string
     */
    protected $_view = 'file';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-hidden';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-file';
}
