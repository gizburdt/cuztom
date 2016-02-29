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
                'post_type'            => 'post',
                'posts_per_page'    => -1,
                'cache_results'    => false,
                'no_found_rows'    => true,
            ),
            $this->args
        );

        $this->posts = get_posts($this->args);
    }
}
