<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class PostSelect extends Select
{
    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-select cuztom-input-post-select';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-post-select';

    /**
     * Construct.
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
     * Output input.
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/post-select', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
