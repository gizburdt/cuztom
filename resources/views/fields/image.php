<?php use Gizburdt\Cuztom\Cuztom; ?>

<v-cuztom-image
    id="<?php echo $field->getId(); ?>"
    attachment="<?php echo Cuztom::jsonEncode($attachment) ?>"
    inline-template
>
    <?php echo $field->outputInput($value, 'text'); ?>

    <input
        id="<?php echo $field->getId(); ?>"
        type="button"
        class="button button-small"
        value="<?php _e('Select image', 'cuztom'); ?>"
        @click.prevent="chooseMedia"
    >

    <a
        href="#"
        class="button button-small"
        title="<?php _e('Remove current image', 'cuztom'); ?>"
        tabindex="-1"
        @click.prevent="removeMedia"
        v-if="value"
        v-cloak
    >x</a>

    <span
        class="cuztom-media__preview"
        v-show="value"
        v-cloak
    >{{{ preview }}}</span>
</v-cuztom-image>