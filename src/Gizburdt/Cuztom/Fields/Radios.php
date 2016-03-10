<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Radios extends Field
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
    public $row_css_class = 'cuztom-field-radios';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->default_value = (array) $this->default_value;
        $this->after_name   .= '[]';
    }

    /**
     * Output input.
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-checkboxes-wrap cuztom-radios-wrap">
            <?php if (is_array($this->options)) : ?>
                <?php foreach ($this->options as $slug => $name) : ?>
                    <label for="<?php echo $this->get_id(Cuztom::uglify($slug)); ?>">
                        <?php echo $this->_output_option($value, $this->default_value, $slug); ?>
                        <?php echo Cuztom::beautify($name); ?>
                    </label>
                    <br/>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Parse value.
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
