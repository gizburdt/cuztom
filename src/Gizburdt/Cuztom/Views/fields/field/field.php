<input
    type="<?php echo $field->get_input_type(); ?>"
    name="<?php echo $field->get_name(); ?>"
    id="<?php echo $field->get_id(); ?>"
    class="<?php echo $field->get_css_class(); ?>"
    value="<?php echo $value; ?>"
    <?php echo $field->get_data_attributes(); ?>
    />
