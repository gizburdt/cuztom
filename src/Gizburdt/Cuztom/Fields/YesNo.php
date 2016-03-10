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
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-radio';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-yesno';

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-radios">
            <?php foreach (array('yes', 'no') as $answer) : ?>
                <label for="<?php echo $this->get_id($answer); ?>">
                    <?php echo $this->_output_option($value, $this->default_value, $answer); ?>
                    <?php echo ($answer == 'yes' ? __('Yes', 'cuztom') : __('No', 'cuztom')); ?>
                </label>
                <br />
            <?php endforeach; ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
