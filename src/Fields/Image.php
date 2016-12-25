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
    public $css_class       = 'cuztom-input--hidden';
    public $cell_css_class  = 'cuztom-field--image';
    public $data_attributes = array('media-type' => 'image');

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

    /**
     * Get preview size.
     *
     * @return string
     */
    public function getPreviewSize()
    {
        $size = (! Cuztom::isEmpty($this->args['preview_size'])
            ? $this->args['preview_size']
            : 'medium');

        return apply_filters('cuztom_field_image_preview_size', $size, $this);
    }
}
