<tr class="cuztom-control cuztom-control-<?php echo $class; ?>" data-control-for="<?php echo $bundle->id; ?>">
    <td colspan="2">
        <a class="button-secondary button button-small cuztom-button js-cuztom-add-sortable" data-sortable-type="bundle" data-field-id="<?php $bundle->id; ?>" href="#">
            <?php echo sprintf('+ %s', __('Add item', 'cuztom')); ?>
        </a>

        <?php if ($bundle->limit) : ?>
            <div class="cuztom-counter js-cztm-counter">
                <span class="current js-current"><?php count($bundle->get_value()); ?></span>
                <span class="divider"> / </span>
                <span class="max js-max"><?php $bundle->limit; ?></span>
            </div>
        <?php endif; ?>
    </td>
</tr>
