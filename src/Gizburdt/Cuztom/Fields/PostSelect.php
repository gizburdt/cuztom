<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Select;

Guard::directAccess();

class PostSelect extends Select
{
    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input cuztom-select cuztom-post-select';

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
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'cache_results'  => false,
                'no_found_rows'  => true,
            ),
            $this->args
        );

        $this->posts = get_posts($this->args);
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
        $i = 0;
        ob_start(); ?>

        <div class="cuztom-select-wrap">
            <select name="<?php echo $this->get_name(); ?>" id="<?php echo $this->get_id(); ?>" class="<?php echo $this->get_css_class(); ?>" <?php echo $this->get_data_attributes(); ?>>
                <?php echo $this->maybe_show_option_none(); ?>

                <?php if (is_array($this->posts)) : ?>
                    <?php foreach ($this->posts as $post) : ?>
                        <option value="<?php echo $post->post_name; ?>" <?php selected($post->ID, $value[$i]); ?>>
                            <?php echo $post->post_title; ?>
                        </option>

                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
