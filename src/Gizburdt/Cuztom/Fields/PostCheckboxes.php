<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Checkboxes;

Guard::directAccess();

class PostCheckboxes extends Checkboxes
{
    /**
     * Construct
     *
     * @param string $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->args = array_merge(
            array(
                'post_type'        => 'post',
                'posts_per_page'   => -1
            ),
            $this->args
        );

        $this->default_value  = (array) $this->default_value;
        $this->posts          = get_posts($this->args);
        $this->after         .= '[]';
    }

    /**
     * Output
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        ob_start(); ?>

        <div class="cuztom-checkboxes-wrap">
            <?php if (is_array($this->posts)) : ?>
                <?php foreach ($this->posts as $post) : ?>
                    <label for="<?php echo $this->get_id($post->post_name) ?>">
                        <?php echo $this->_output_option($post->ID, $this->default_value, $post->post_name); ?>
                        <?php echo $post->post_title; ?>
                    </label>
                    <br/>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
