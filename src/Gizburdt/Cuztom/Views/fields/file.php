<?php

use Gizburdt\Cuztom\Cuztom;

if (! Cuztom::is_empty($value)) {
    $attachment = get_attached_file($value);
    $mime       = str_replace('/', '-', get_post_mime_type($value));
    $name       = get_the_title($value);
    $file       = '<span class="cuztom-mime mime-'.$mime.'"><a target="_blank" href="'.$attachment.'">'.$name.'</a></span>';
} else {
    $file       = '';
}

?>

<?php echo $field->_output_input($value, 'text'); ?>
<input type="button" id="<?php echo $field->get_id(); ?>" class="button button-small js-cuztom-upload" data-media-type="file" value="<?php _e('Select file', 'cuztom'); ?>" />
<?php echo (! empty($value) ? sprintf('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" title="%s">x</a>', __('Remove current file', 'cuztom')) : ''); ?>
<span class="cuztom-preview"><?php echo $file; ?></span>
