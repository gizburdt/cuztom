<v-cuztom-repeatable
    id="<?php echo $field->getId(); ?>"
    inline-template
>
    <div class="cuztom-repeatable">
        <?php echo $field->_outputRepeatableControl(); ?>

        <ul class="cuztom-sortable__list js-cuztom-sortable-list">
            <?php
                if (is_array($values)) {
                    foreach ($values as $value) {
                        echo $field->_outputRepeatableItem($value);
                    }
                } else {
                    echo $field->_outputRepeatableItem($values);
                }
            ?>
        </ul>
    </div>
</v-cuztom-repeatable>