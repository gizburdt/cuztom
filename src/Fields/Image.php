<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Image extends Field
{
    /**
     * Input type.
     * @var string
     */
    public $input_type = 'hidden';

    /**
     * View name.
     * @var string
     */
    public $view = 'image';

    /**
     * CSS class.
     * @var string
     */
    public $css_class = 'cuztom-input-hidden';

    /**
     * Row CSS class.
     * @var string
     */
    public $row_css_class = 'cuztom-field-image';

    /**
     * Data attributes.
     * @var array
     */
    public $data_attributes = array('media-type' => 'image');

    /**
     * Output column content.
     *
     * @param  string $post_id
     * @return string
     * @since  3.0
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
     * @since  3.0
     */
    public function getPreviewSize()
    {
        $size = (! Cuztom::isEmpty($this->args['preview_size'])
            ? $this->args['preview_size']
            : 'medium');

        return apply_filters('cuztom_field_image_preview_size', $size, $this);
    }
}
