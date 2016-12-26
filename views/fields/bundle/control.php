<div class="cuztom-sortable__control <?php echo isset($class) ? $class : ''; ?>">
    <a class="button button-small" href="#">
        <?php _e('Add item', 'cuztom'); ?>
    </a>

    <?php if ($bundle->limit) : ?>
        <div class="cuztom-sortable__counter">
            <span class="current"><?php echo count($bundle->value); ?></span>
            <span class="divider"> / </span>
            <span class="max"><?php echo $bundle->limit; ?></span>
        </div>
    <?php endif; ?>
</div>