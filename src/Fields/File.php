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
    public $input_type = 'hidden';

    /**
     * View name.
     * @var string
     */
    public $view = 'file';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-hidden';

    /**
     * Cell CSS class.
     * @var string
     */
    public $cell_css_class = 'cuztom-field-file';

    /**
     * Data attributes.
     * @var array
     */
    public $data_attributes = array('media-type' => 'file');
}
