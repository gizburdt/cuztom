<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Image extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'hidden';
    public $view      = 'image';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--hidden';
    public $cell_css_class = 'cuztom-field--image';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->html_attributes = array(
            'v-model' => 'value'
        );
    }

    /**
     * Output input field.
     *
     * @param  string $value
     * @param  string $view
     * @return string
     */
    public function outputInput($value = null, $view = null)
    {
        $view = $view ? $view : $this->getView();

        $attachment = wp_get_attachment_metadata($value);

        @$attachment['url'] = wp_get_attachment_image_src($value, 'medium')[0];

        return Cuztom::view('fields/'.$view, array(
            'field'      => $this,
            'value'      => $value,
            'attachment' => $attachment
        ));
    }

    /**
     * Output column content.
     *
     * @param  string $post_id
     * @return string
     */
    public function outputColumnContent($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        echo wp_get_attachment_image($meta, array(100, 100));
    }
}
