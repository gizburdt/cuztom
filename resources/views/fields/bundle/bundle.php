<?php use Gizburdt\Cuztom\Cuztom; ?>

<tr class="cuztom-cell cuztom-bundle" v-cloak>
    <td class="cuztom-field" colspan="2">
        <v-cuztom-bundle
            id="<?php echo $bundle->getId(); ?>"
            box="<?php echo $bundle->parent; ?>"
            inline-template
        >
            <?php echo $bundle->outputControl('control--top'); ?>

            <ul class="cuztom-sortable__list js-cuztom-sortable" v-if="list.length">
                <li class="cuztom-sortable__item" v-for="item in list" track-by="$index">{{{ item }}}</li>
            </ul>

            <em class="cuztom-sortable__none" v-if="!list.length"><?php _e('No items found.', 'cuztom'); ?></em>

            <?php echo $bundle->outputControl('control--bottom'); ?>
        </v-cuztom-bundle>
    </td>
</tr>