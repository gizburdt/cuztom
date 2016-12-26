<tr class="cuztom-cell cuztom-bundle">
    <td class="cuztom-field" id="<?php echo $bundle->getId(); ?>" data-id="<?php echo $bundle->getId(); ?>" colspan="2">
        <?php echo $bundle->outputControl('control--top'); ?>

        <ul class="cuztom-sortable__list js-cuztom-sortable">
            <?php echo $bundle->output(); ?>
        </ul>

        <?php echo $bundle->outputControl('control--bottom'); ?>
    </td>
</tr>