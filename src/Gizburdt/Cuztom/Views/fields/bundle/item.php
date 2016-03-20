<li class="cuztom-sortable-item js-cuztom-sortable-item">
    <div class="cuztom-handle-sortable js-cuztom-handle-sortable">
        <a href="#"></a>
    </div>

    <fieldset class="cuztom-fieldset">
        <table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">
            <?php foreach ($bundle->fields as $id => $field) : ?>
                <?php
                    $field->before_name   = '['.$bundle->get_id().']['.$index.']';
                    $field->after_id      = '_'.$index;
                    $field->default_value = isset($bundle->default_value[$index][$id]) ? $bundle->default_value[$index][$id] : $field->default_value;
                    $value                = isset($bundle->get_value()[$index][$id]) ? $bundle->get_value()[$index][$id] : '';
                ?>

                <?php echo $field->output_row($value); ?>
            <?php endforeach; ?>
        </table>
    </fieldset>

    <div class="cuztom-remove-sortable js-cuztom-remove-sortable"><a href="#"></a></div>
</li>
