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
            $attachment = get_attached_file($value);
            $mime       = str_replace('/', '-', get_post_mime_type($value));
            $name       = get_the_title($value);
            $file       = '<span class="cuztom-mime mime-'.$mime.'"><a target="_blank" href="'.$attachment.'">'.$name.'</a></span>';
        } else {
            $file       = '';
        }

        ?>

        <?php echo parent::_output_input($value); ?>
        <input type="button" id="<?php echo $this->get_id(); ?>" class="button button-small js-cuztom-upload" data-media-type="file" value="<?php _e('Select file', 'cuztom'); ?>" />
        <?php echo (! empty($value) ? sprintf('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" title="%s">x</a>', __('Remove current file', 'cuztom')) : ''); ?>
        <span class="cuztom-preview"><?php echo $file; ?></span>

        <?php $ob = ob_get_clean(); return $ob;
    }
}
