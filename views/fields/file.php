<?php use Gizburdt\Cuztom\Cuztom; ?>

<v-cuztom-media
    type="file"
    attachment="<?php echo Cuztom::htmlSpecialJsonEncode($attachment) ?>"
    inline-template
>
    <?php echo $field->_outputInput($value, 'text'); ?>

    <input
        type="button"
        id="<?php echo $field->getId(); ?>"
        class="button button-small"
        value="<?php _e('Select file', 'cuztom'); ?>"
        @click.prevent="chooseMedia"
    />

    <a
        href="#"
        class="button button-small"
        title="<?php _e('Remove current file', 'cuztom'); ?>"
        tabindex="-1"
        @click.prevent="removeMedia"
        v-if="value"
        v-cloak
    >x</a>

    <span
        class="cuztom-media__preview"
        v-show="value"
        v-cloak
    >
        <span class="cuztom-media__mime mime--application-pdf">
        {{{ preview }}}
    </span>
</v-cuztom-media>