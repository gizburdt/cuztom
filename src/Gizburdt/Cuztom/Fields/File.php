<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class File extends Field
{
    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * CSS class
     * @var string
     */
    public $css_class = 'cuztom-input-hidden';

    /**
     * Row CSS class
     * @var string
     */
    public $row_css_class = 'cuztom-field-file';

    /**
     * Output input
     *
     * @param  string $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null)
    {
        ob_start();

        if (! Cuztom::is_empty($value)) {
            $attachment = self::get_attachment_by_url($value);

            if (is_object($attachment)) {
                $mime = str_replace('/', '_', $attachment->post_mime_type);
                $name = $attachment->post_title;
            } else {
                $mime = '';
            }

            $file = '<span class="cuztom-mime mime-' . $mime . '"><a target="_blank" href="' . $value . '">' . $name . '</a></span>';
        } else {
            $file = '';
        }

        ?>

        <?php echo parent::_output_input($value); ?>
        <input type="button" id="<?php echo $this->get_id(); ?>" class="button button-small js-cztm-upload" value="<?php _e('Select file', 'cuztom'); ?>" />
        <?php echo (! empty($value) ? sprintf('<a href="#" class="cuztom-remove-media js-cuztom-remove-media">%s</a>', __('Remove current file', 'cuztom')) : ''); ?>
        <span class="cuztom-preview"><?php echo $file; ?></span>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Get attachment by given url
     *
     * @param  string 			$url
     * @return integer
     * @since  2.4
     */
    public function get_attachment_by_url($url)
    {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare("SELECT ID,post_title,post_mime_type FROM " . $wpdb->prefix . "posts" . " WHERE guid=%s;", $url));
    }
}
