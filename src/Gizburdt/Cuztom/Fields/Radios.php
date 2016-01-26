<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Radios extends Field
{
    use Checkable;

    /**
     * Css class
     * @var string
     */
    public $css_class = 'cuztom-input';

    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'radio';

    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->after_name .= '[]';
    }

    /**
     * Output
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $ob    = '';
        $count = 0;

        ob_start(); ?>

        <div class="cuztom-checkboxes cuztom-radios">
            <?php if (is_array($this->options)) : ?>
                <?php foreach ($this->options as $slug => $name) : ?>
                    <label for="<?php echo $this->get_id(Cuztom::uglify($slug)); ?>">
                        <?php echo $this->_output_option($value, $slug); ?>
                        <?php echo Cuztom::beautify($name); ?>
                    </label>
                    <br />

                    <?php $count++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php $this->output_explanation(); ?>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Parse value
     *
     * @param  string|array $value
     * @return string
     * @since  2.8
     */
    public function parse_value($value)
    {
        return is_array($value) ? @$value[0] : $value;
    }
}
