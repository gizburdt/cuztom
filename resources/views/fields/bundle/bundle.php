<?php use Gizburdt\Cuztom\Cuztom; ?>

<tr class="cuztom-cell cuztom-bundle js-cuztom-bundle" v-cloak>
    <td class="cuztom-field" colspan="2">
        <v-cuztom-bundle
            id="<?php echo $bundle->getId(); ?>"
            box="<?php echo $bundle->parent; ?>"
            object="<?php echo $bundle->object; ?>"
            inline-template
        >
            <?php echo $bundle->outputControl('control--top'); ?>

            <ul class="cuztom-sortable__list js-cuztom-sortable" v-if="list.length">
                <li class="cuztom-sortable__item" v-for="item in list" track-by="$index">
                    <div class="cuztom-sortable__item__control">
                        <div class="cuztom-sortable__item__handle js-cuztom-sortable-item-handle">
                            <a href="#" tabindex="-1"></a>
                        </div>

                        <div class="cuztom-sortable__item__remove">
                            <a href="#" tabindex="-1" @click.prevent="removeItem(item)"></a>
                        </div>
                    </div>

                    {{{ item }}}
                </li>
            </ul>

            <em class="cuztom-sortable__none" v-if="!list.length"><?php _e('No items found.', 'cuztom'); ?></em>

            <?php echo $bundle->outputControl('control--bottom'); ?>
        </v-cuztom-bundle>
    </td>
</tr>