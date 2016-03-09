<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class MultiSelect extends Select
{
    use Selectable;

    /**
     * CSS class.
     *
     * @var string
     */
    public $css_class = 'cuztom-input-select cuztom-input-multi-select';

    /**
     * Row CSS class.
     *
     * @var string
     */
    public $row_css_class = 'cuztom-field-multi-select';

    /**
     * Construct.
     *
     * @param array $field
     *
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->after_name          .= '[]';
        $this->args['multiselect']  = true;
    }

    /**
     * Output input.
     *
     * @param string|array $value
     *
     * @return string
     *
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        $i = 0;
        ob_start();
        ?>

        <div class="cuztom-select-wrap">
            <select name="<?php echo $this->get_name();
        ?>" id="<?php echo $this->get_id();
        ?>" class="<?php echo $this->get_css_class();
        ?>" multiple="true" <?php echo $this->get_data_attributes();
        ?>>
                <?php echo $this->maybe_show_option_none();
        ?>

                <?php if (is_array($this->options)) : ?>
                    <?php foreach ($this->options as $slug => $name) : ?>
                        <option value="<?php echo $slug;
        ?>" <?php echo is_array($value) ? (in_array($slug, $value) ? 'selected="selected"' : '') : '';
        ?>>
                            <?php echo $name;
        ?>
                        </option>

                        <?php $i++;
        ?>
                    <?php endforeach;
        ?>
                <?php endif;
        ?>
            </select>
        </div>

        <?php $ob = ob_get_clean();

        return $ob;
    }
}
