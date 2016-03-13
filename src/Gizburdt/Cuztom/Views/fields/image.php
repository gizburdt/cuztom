<?php

use Gizburdt\Cuztom\Cuztom;

if (! Cuztom::is_empty($value)) {
    $url   = wp_get_attachment_image_src($value, $field->get_preview_size())[0];
    $image = '<img src="'.$url.'" />';
} else {
    $image = '';
}

?>

<?php echo $field->_output_input($value, 'text'); ?>
<input id="<?php echo $field->get_id(); ?>" type="button" class="button button-small js-cuztom-upload" data-media-type="image" value="<?php _e('Select image', 'cuztom'); ?>" />
<?php echo (! Cuztom::is_empty($value) ? sprintf('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" title="%s" tabindex="-1">x</a>', __('Remove current image', 'cuztom')) : ''); ?>
<span class="cuztom-preview cuztom-preview-image"><?php echo $image; ?></span>
