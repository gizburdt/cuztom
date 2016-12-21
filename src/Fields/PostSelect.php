<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class PostSelect extends Select
{
    /**
     * View name.
     * @var string
     */
    public $view = 'post-select';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select cuztom-input-post-select';

    /**
     * Cell CSS class.
     * @var string
     */
    public $cell_css_class = 'cuztom-field-post-select';

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

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
}
