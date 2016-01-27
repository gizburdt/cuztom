<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class YesNo extends Field
{
    use Checkable;

    /**
     * Css class
     * @var string
     */
    public $css_classes = 'cuztom-input';

    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'radio';

    /**
     * Output
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-checkboxes">
            <?php foreach (array('yes', 'no') as $answer) : ?>
                <?php
                    $label = ($answer == 'yes' ? __('Yes', 'cuztom') : __('No', 'cuztom'));
                    echo $this->_output_option($value, $answer);
                    echo sprintf('<label for="%s">%s</label>', $this->get_id($answer), $label);
                ?>
                <br />
            <?php endforeach; ?>
        </div>
        <?php echo $this->output_explanation(); ?>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
