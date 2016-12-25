<?php echo $bundle->outputControl(); ?>

<tr class="cuztom-bundle">
    <td class="cuztom-field" id="<?php echo $bundle->getId(); ?>" data-id="<?php echo $bundle->getId(); ?>" colspan="2">
        <div class="cuztom-bundles cuztom-bundles-<?php echo $bundle->getId(); ?>">
            <ul class="cuztom-sortable js-cuztom-sortable">
                <?php echo $bundle->output(); ?>
            </ul>
        </div>
    </td>
</tr>

<?php echo $bundle->outputControl('bottom'); ?>
