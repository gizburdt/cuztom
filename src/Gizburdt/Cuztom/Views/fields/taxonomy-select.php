<div class="cuztom-select-wrap">
    <select name="<?php echo $field->get_name(); ?>" id="<?php echo $field->get_id(); ?>" class="<?php echo $field->get_css_class(); ?>" <?php echo $field->get_data_attributes(); ?>>
        <?php echo $field->maybe_show_option_none(); ?>

        <?php if (is_array($field->taxonomies)) : ?>
            <?php foreach ($field->taxonomies as $taxonomy) : ?>

                <option value="<?php echo $taxonomy->name; ?>" <?php selected($taxonomy->name, $value); ?>>
                    <?php echo $taxonomy->labels->singular_name; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
