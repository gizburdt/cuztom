<textarea
    name="<?php echo $field->get_name(); ?>"
    id="<?php echo $field->get_id(); ?>"
    class="<?php echo $field->get_css_class(); ?>"
    <?php echo $field->get_data_attributes(); ?>
    ><?php echo $value; ?></textarea>
