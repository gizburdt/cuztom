<?php

use Gizburdt\Cuztom\Cuztom;

if (! Cuztom::isEmpty($value)) {
    $url   = wp_get_attachment_image_src($value, $field->getPreviewSize())[0];
    $image = '<img src="'.$url.'" />';
} else {
    $image = '';
}

?>

<?php echo $field->_outputInput($value, 'text'); ?>
<input id="<?php echo $field->getId(); ?>" type="button" class="button button-small js-cuztom-upload" data-media-type="image" value="<?php _e('Select image', 'cuztom'); ?>" />
<?php echo (! Cuztom::isEmpty($value) ? sprintf('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" title="%s" tabindex="-1">x</a>', __('Remove current image', 'cuztom')) : ''); ?>
<span class="cuztom-preview cuztom-preview-image"><?php echo $image; ?></span>
