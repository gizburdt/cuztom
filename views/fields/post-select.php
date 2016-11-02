<div class="cuztom-select-wrap">
    <select name="<?php echo $field->get_name(); ?>" id="<?php echo $field->get_id(); ?>" class="<?php echo $field->get_css_class(); ?>" <?php echo $field->get_data_attributes(); ?>>
        <?php echo $field->maybe_show_option_none(); ?>

        <?php if (is_array($field->posts)) : ?>
            <?php foreach ($field->posts as $post) : ?>
                <option value="<?php echo $post->ID; ?>" <?php selected($post->ID, $value); ?>>
                    <?php echo $post->post_title; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
