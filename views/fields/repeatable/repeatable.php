<div class="cuztom-repeatable v-cuztom-repeatable">
    <?php echo $field->_outputRepeatableControl($values); ?>

    <ul class="cuztom-sortable">
        <?php
            if (is_array($values)) {
                foreach ($values as $value) {
                    echo $field->_outputRepeatableItem($value, count($values));

                    if ($field->limit && ++$count >= $field->limit) {
                        break;
                    }
                }
            } else {
                echo $field->_outputRepeatableItem($values, 1);
            }
        ?>
    </ul>
</div>
