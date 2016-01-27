<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class File extends Field
{
    /**
     * Css class
     * @var string
     */
    public $css_class = 'cuztom-hidden cuztom-input';

    /**
     * Input type
     * @var string
     */
    protected $_input_type = 'hidden';

    /**
     * Output method
     *
     * @return  string
     *
     * @author 	Gijs Jorissen
     * @since 	2.4
     *
     */
    public function _output($value = null)
    {
        ob_start();

        if (! empty($value)) {
            $attachment = self::get_attachment_by_url($value);
            $mime = '';

            if (is_object($attachment)) {
                $mime = str_replace('/', '_', $attachment->post_mime_type);
                $name = $attachment->post_title;
            }

            $file = '<span class="cuztom-mime mime-' . $mime . '"><a target="_blank" href="' . $value . '">' . $name . '</a></span>';
        } else {
            $file = '';
        } ?>

        <?php echo parent::_output_input($value); ?>
        <input id="<?php echo $this->get_id(); ?>" type="button" class="button js-cztm-upload" value="<?php _e('Select file', 'cuztom'); ?>" />
        <?php echo (! empty($value) ? sprintf('<a href="#" class="js-cztm-remove-media cuztom-remove-media">%s</a>', __('Remove current file', 'cuztom')) : ''); ?>

        <span class="cuztom-preview"><?php echo $file; ?></span>
        <?php echo $this->output_explanation(); ?>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Get attachment by given url
     *
     * @param  string 			$url
     * @return integer
     */
    public function get_attachment_by_url($url)
    {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare("SELECT ID,post_title,post_mime_type FROM " . $wpdb->prefix . "posts" . " WHERE guid=%s;", $url));
    }
}
