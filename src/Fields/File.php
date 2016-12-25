<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class File extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'hidden';
    public $view      = 'file';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class       = 'cuztom-input--hidden';
    public $cell_css_class  = 'cuztom-field--file';
    public $data_attributes = array('media-type' => 'file');
}
