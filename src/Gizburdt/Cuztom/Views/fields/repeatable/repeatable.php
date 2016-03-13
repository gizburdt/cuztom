<div class="cuztom-repeatable">
    <?php echo $field->_output_repeatable_control($value); ?>
    <ul class="cuztom-sortable js-cuztom-sortable">
        <?php
            if (is_array($value)) {
                foreach ($values as $value) {
                    echo $field->_output_repeatable_item($value, $values);

                    if ($count++ >= $field->limit) {
                        break;
                    }
                }
            } else {
                echo $field->_output_repeatable_item($value, $values);
            }
        ?>
    </ul>
</div>
