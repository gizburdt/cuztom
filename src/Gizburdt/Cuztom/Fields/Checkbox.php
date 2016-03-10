<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Traits\Checkable;

Guard::directAccess();

class Checkbox extends Field
{
    use Checkable;

    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'checkbox';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-checkbox';

    /**
     * Output
     *
     * @param  string|array $value
     * @return string
     * @since  3.0
     */
    public function _output_input($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-checkbox">
            <?php echo $this->_output_option($value, $this->default_value, 'on'); ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
