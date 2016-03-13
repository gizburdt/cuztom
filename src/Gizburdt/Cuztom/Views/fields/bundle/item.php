<li class="cuztom-sortable-item">
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
                    $value                = isset($bundle->value[$index][$id]) ? $bundle->value[$index][$id] : '';
                ?>

                <?php if (! $field instanceof Hidden) : ?>
                    <tr>
                        <th class="cuztom-th">
                            <label for="'.$id.$field->after_id.'" class="cuztom-label">'.$field->label.'</label>
                            <div class="cuztom-field-description">'.$field->description.'</div>
                        </th>
                        <td class="cuztom-td">
                            <?php if ($field->_supports_bundle) : ?>
                                <?php echo $field->output($value); ?>
                            <?php else : ?>
                                <em><?php _e('This input type doesn\'t support the bundle functionality (yet).', 'cuztom'); ?></em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php echo $field->output($value); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </fieldset>

    <?php count($bundle->get_value) > 1 ? '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"><a href="#"></a></div>' : ''; ?>
</li>
