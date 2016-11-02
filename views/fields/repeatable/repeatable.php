<div class="cuztom-repeatable">
    <?php echo $field->_output_repeatable_control($values); ?>

    <ul class="cuztom-sortable js-cuztom-sortable">
        <?php
            if (is_array($values)) {
                foreach ($values as $value) {
                    echo $field->_output_repeatable_item($value, count($values));

                    if($field->limit && ++$count >= $field->limit) {
                        break;
                    }
                }
            } else {
                echo $field->_output_repeatable_item($value, 1);
            }
        ?>
    </ul>
</div>
