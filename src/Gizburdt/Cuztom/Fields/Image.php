<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class Image extends Field
{
    /**
     * Css classes
     * @var string
     */
    public $css_class = 'cuztom-hidden cuztom-input';

    /**
     * Data attributes
     * @var array
     */
    public $data_attributes = array( 'media-type' => 'image' );

    /**
     * Output
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        $image = '';

        // Set image
        if (! Cuztom::is_empty($value)) {
            $url   = wp_get_attachment_image_src($value, $this->get_preview_size());
            $url   = $url[0];
            $image = '<img src="'.$url.'" />';
        }

        $ob  = '<input type="hidden" '.$this->output_name().' '.$this->output_css_class().' value="'.(! Cuztom::is_empty($value) ? $value : '').'" />';
        $ob .= '<input '.$this->output_id().' '.$this->output_data_attributes().' type="button" class="button button-small js-cuztom-upload" '.sprintf('value="%s"', __('Select image', 'cuztom')).'/>';
        $ob .= (! Cuztom::is_empty($value) ? sprintf('<a href="#" class="js-cztm-remove-media cuztom-remove-media" title="%s" tabindex="-1"></a>', __('Remove current file', 'cuztom')) : '');
        $ob .= '<span class="cuztom-preview">'.$image.'</span>';
        $ob .= $this->output_explanation();

        return $ob;
    }

    /**
     * Output column content
     *
     * @param  string $post_id
     * @return string
     * @since  3.0
     */
    public function output_column_content($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        echo wp_get_attachment_image($meta, array( 100, 100 ));
    }

    /**
     * Get preview size
     *
     * @return string
     * @since  3.0
     */
    private function get_preview_size()
    {
        $size = (! Cuztom::is_empty($this->args["preview_size"]) ? $this->args["preview_size"] : 'medium');

        return apply_filters('cuztom_field_image_preview_size', $size, $this);
    }
}
