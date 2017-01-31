<div class="cuztom-sortable__control <?php echo isset($class) ? $class : ''; ?>">
    <a
        class="button button-small"
        href="#"
        @click.prevent="addItem"
        :disabled="(<?php echo $bundle->limit ?> && list.length >= <?php echo $bundle->limit ?>) || loading"
    >
        <?php _e('Add item', 'cuztom'); ?>
    </a>

    <em class="cuztom-sortable__loading" v-if="loading">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" class="loading">
    </em>

    <?php if ($bundle->limit) : ?>
        <div class="cuztom-sortable__counter">
            <span class="current">{{ list.length }}</span>
            <span class="divider"> / </span>
            <span class="max"><?php echo $bundle->limit; ?></span>
        </div>
    <?php endif; ?>
</div>