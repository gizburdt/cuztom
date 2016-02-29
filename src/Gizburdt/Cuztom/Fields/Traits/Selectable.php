<?php

namespace Gizburdt\Cuztom\Fields\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

trait Selectable
{
    /**
     * Output option
     *
     * @param  string $value
     * @param  string $option
     * @return string
     * @since  3.0
     */
    public function _output_input($value = null, $options = null, $args = null)
    {
        $value   = $value ? $value : $this->value;
        $options = $options ? $options : $this->options;
        $args    = $args ? $args : $this->args;

        ob_start(); ?>

        <div class="cuztom-select-wrap">
            <select name="<?php echo $this->get_name(); ?>" id="<?php echo $this->get_id(); ?>" class="<?php echo $this->get_css_class(); ?>" <?php echo $this->maybeMultiselect($args); ?>>
                <?php echo $this->maybeShowOptionNone($args); ?>

                <?php if (is_array($options)) : ?>
                    <?php foreach ($options as $slug => $name) : ?>
                        <option value="<?php echo $slug; ?>" <?php echo ((isset($value) && strlen($value) > 0) ? selected($slug, $value, false) : selected($this->default_value, $slug, false)); ?>>
                            <?php echo Cuztom::beautify($name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Is select multiselect?
     *
     * @return string
     * @since  3.0
     */
    protected function maybeMultiselect($args)
    {
        return (@$args['multiselect'] ? 'multiple="true"' : '');
    }

    /**
     * Show option none?
     *
     * @return string
     * @since  3.0
     */
    protected function maybeShowOptionNone($args)
    {
        if(! @$args['show_option_none']) {
            return;
        }

        return '<option value="0" '.(Cuztom::is_empty($value) ? 'selected="selected"' : '').'>'.$this->args['show_option_none'].'</option>';
    }
}
