<tr class="cuztom-control cuztom-control-<?php echo $class; ?> js-cuztom-control" data-control-for="<?php echo $bundle->id; ?>">
    <td colspan="2">
        <a class="cuztom-button js-cuztom-add-sortable button button-secondary button-small" data-sortable-type="bundle" data-field-id="<?php echo $bundle->get_id(); ?>" href="#">
            <?php _e('Add item', 'cuztom'); ?>
        </a>

        <?php if ($bundle->limit) : ?>
            <div class="cuztom-counter js-cuztom-counter">
                <span class="current js-current"><?php echo count($bundle->get_value()); ?></span>
                <span class="divider"> / </span>
                <span class="max js-max"><?php echo $bundle->limit; ?></span>
            </div>
        <?php endif; ?>
    </td>
</tr>
