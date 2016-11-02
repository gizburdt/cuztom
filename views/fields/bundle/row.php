<?php echo $bundle->output_control(); ?>

<tr class="cuztom-bundle">
    <td class="cuztom-field js-cuztom-field" id="<?php echo $bundle->get_id(); ?>" data-id="<?php echo $bundle->get_id(); ?>" colspan="2">
        <div class="cuztom-bundles cuztom-bundles-<?php echo $bundle->get_id(); ?>">
            <ul class="cuztom-sortable js-cuztom-sortable">
                <?php echo $bundle->output(); ?>
            </ul>
        </div>
    </td>
</tr>

<?php echo $bundle->output_control('bottom'); ?>
