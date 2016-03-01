<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-select';

    /**
     * Output input
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        $i = 0;
        ob_start(); ?>

        <div class="cuztom-select-wrap">
            <select name="<?php echo $this->get_name(); ?>" id="<?php echo $this->get_id(); ?>" class="<?php echo $this->get_css_class(); ?>" <?php echo $this->get_data_attributes(); ?>>
                <?php echo $this->maybe_show_option_none(); ?>

                <?php if (is_array($this->options)) : ?>
                    <?php foreach ($this->options as $slug => $name) : ?>
                        <option value="<?php echo $slug; ?>" <?php selected($slug, $value); ?>>
                            <?php echo $name; ?>
                        </option>

                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
