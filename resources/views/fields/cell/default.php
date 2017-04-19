<tr class="cuztom-cell">
    <th>
        <label for="<?php echo $field->getId(); ?>" class="cuztom-field__label"><?php echo $field->label; ?></label>
        <?php echo ($field->required ? ' <span class="cuztom-field__required">*</span>' : ''); ?>
        <div class="cuztom-field__description"><?php echo $field->description; ?></div>
    </th>
    <td class="<?php echo $field->getCellCssClass(); ?>" data-id="<?php echo $field->getId(); ?>">
        <?php echo $field->output($value); ?>
    </td>
</tr>
