<div class="cuztom-control">
    <a
        href="#"
        class="cuztom-button button button-secondary button-small"
        @click.prevent="addItem"
    >
        <?php _e('Add item', 'cuztom'); ?>
    </a>

    <?php if ($field->limit) : ?>
        <div class="cuztom-counter" v-cloak>
            <span class="current">{{ list.length }}</span>
            <span class="divider"> / </span>
            <span class="max"><?php echo $field->limit; ?></span>
        </div>
    <?php endif; ?>
</div>
