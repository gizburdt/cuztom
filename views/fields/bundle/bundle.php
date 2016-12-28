<?php use Gizburdt\Cuztom\Cuztom; ?>

<tr class="cuztom-cell cuztom-bundle">
    <td class="cuztom-field" colspan="2">
        <v-cuztom-bundle
            id="<?php echo $bundle->getId(); ?>"
            box="<?php echo $bundle->parent; ?>"
            :values="<?php echo Cuztom::jsonEncode($bundle->value); ?>"
            inline-template
        >
            <?php echo $bundle->outputControl('control--top'); ?>

            <ul class="cuztom-sortable__list js-cuztom-sortable" v-if="list.length">
                <?php echo $bundle->output(); ?>
            </ul>

            <em class="cuztom-sortable__none" v-if="!list.length">No items found</em>

            <?php echo $bundle->outputControl('control--bottom'); ?>
        </v-cuztom-bundle>
    </td>
</tr>