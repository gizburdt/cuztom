<?php use Gizburdt\Cuztom\Cuztom; ?>

<v-cuztom-repeatable
    id="<?php echo $field->getId(); ?>"
    box="<?php echo $field->parent; ?>"
    :values="<?php echo Cuztom::jsonEncode($field->value); ?>"
    inline-template
>
    <div class="cuztom-repeatable" v-cloak>
        <?php echo $field->_outputRepeatableControl(); ?>

        <ul class="cuztom-sortable__list js-cuztom-sortable" v-if="list.length">
            <li class="cuztom-field cuztom-sortable__item" v-for="item in list" track-by="$index">
                <div class="cuztom-sortable__item__handle js-cuztom-sortable-item-handle">
                    <a href="#" tabindex="-1"></a>
                </div>

                <div class="cuztom-sortable__item__content">{{{ item }}}</div>

                <div class="cuztom-sortable__item__remove">
                    <a href="#" tabindex="-1" @click.prevent="removeItem(item)"></a>
                </div>
            </li>
        </ul>

        <em class="cuztom-sortable__none" v-if="!list.length">No items found</em>
    </div>
</v-cuztom-repeatable>