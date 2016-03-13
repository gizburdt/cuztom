<tr>
    <th>
        <label for="<?php echo $field->get_id(); ?>" class="cuztom-label"><?php echo $field->label; ?></label>
        <?php echo ($field->required ? ' <span class="cuztom-required">*</span>' : ''); ?>
        <div class="cuztom-field-description"><?php echo $field->description; ?></div>
    </th>
    <td class="<?php echo $field->get_row_css_class(); ?>" data-id="<?php echo $field->get_id(); ?>">
        <?php echo $field->output(); ?>
    </td>
</tr>
