<div class="cuztom-select-wrap">
    <select name="<?php echo $field->get_name(); ?>" id="<?php echo $field->get_id(); ?>" class="<?php echo $field->get_css_class(); ?>" <?php echo $field->get_data_attributes(); ?>>
        <?php echo $field->maybe_show_option_none(); ?>

        <?php if (is_array($field->options)) : ?>
            <?php foreach ($field->options as $slug => $name) : ?>
                <option value="<?php echo $slug; ?>" <?php selected($slug, $value); ?>>
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
