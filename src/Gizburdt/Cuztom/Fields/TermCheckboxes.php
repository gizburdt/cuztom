<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Checkboxes;

Guard::directAccess();

class TermCheckboxes extends Checkboxes
{
    /**
     * Terms
     * @var array
     */
    public $terms;

    /**
     * Construct
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->args = array_merge(
            array(
                'taxonomy' => 'category',
            ),
            $this->args
        );

        $this->terms          = get_terms($this->args['taxonomy'], $this->args);
        $this->default_value  = (array) $this->default_value;
        $this->after_name    .= '[]';
    }

    /**
     * Output input
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-checkboxes-wrap">
            <?php if (is_array($this->terms)) : ?>
                <?php foreach ($this->terms as $term) : ?>
                    <label for="<?php echo $this->get_id($term->slug) ?>">
                        <?php echo $this->_output_option($term->ID, $this->default_value, $term->slug); ?>
                        <?php echo $term->name; ?>
                    </label>
                    <br/>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
