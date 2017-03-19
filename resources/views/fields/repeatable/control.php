<div class="cuztom-sortable__control">
    <a
        href="#"
        class="button button-small"
        @click.prevent="addItem"
        :disabled="
            <?php echo $field->limit ? "($field->limit && list.length >= $field->limit)" : "false"; ?>
            || loading
        "
    >
        <?php _e('Add item', 'cuztom'); ?>
    </a>

    <em class="cuztom-sortable__loading" v-if="loading">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" class="loading">
    </em>

    <?php if ($field->limit) : ?>
        <div class="cuztom-sortable__counter" v-cloak>
            <span class="current">{{ list.length }}</span>
            <span class="divider"> / </span>
            <span class="max"><?php echo $field->limit; ?></span>
        </div>
    <?php endif; ?>
</div>
