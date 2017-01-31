<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class PostSelect extends Select
{
    /**
     * Base.
     * @var mixed
     */
    public $view = 'post-select';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--select cuztom-input--post-select';
    public $cell_css_class = 'cuztom-field--post-select';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
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
