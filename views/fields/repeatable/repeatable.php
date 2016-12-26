<?php use Gizburdt\Cuztom\Cuztom; ?>

<v-cuztom-repeatable
    id="<?php echo $field->getId() ?>"
    list="<?php echo Cuztom::jsonEncode($values); ?>"
    inline-template
>
    <div class="cuztom-repeatable">
        <?php echo $field->_outputRepeatableControl(); ?>

        <ul class="cuztom-sortable__list" v-cloak>
            <li class="cuztom-field cuztom-sortable__item" v-for="item in list">
                <div class="cuztom-sortable__item__handle js-cuztom-sortable-item-handle"><a href="#" tabindex="-1"></a></div>
                <!-- <slot></slot> -->
                <div class="cuztom-sortable__item__remove js-cuztom-sortable-item-remove"><a href="#" tabindex="-1"></a></div>
            </li>
        </ul>
    </div>
</v-cuztom-repeatable>