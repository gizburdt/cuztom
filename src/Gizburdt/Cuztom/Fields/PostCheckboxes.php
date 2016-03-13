<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class PostCheckboxes extends Checkboxes
{
    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-post-checkboxes';

    /**
     * Construct.
     *
     * @param string $field
     * @since 0.3.3
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->args = array_merge(
            array(
                'post_type'      => 'post',
                'posts_per_page' => -1
            ),
            $this->args
        );

        $this->default_value = (array) $this->default_value;
        $this->posts         = get_posts($this->args);
    }

    /**
     * Output.
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        Cuztom::view('fields/post-checkboxes', array(
            'field' => $this,
            'value' => $value
        ));
    }
}
