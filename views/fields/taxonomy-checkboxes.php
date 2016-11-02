<div class="cuztom-checkboxes-wrap">
    <?php if (is_array($field->taxonomies)) : ?>
        <?php foreach ($field->taxonomies as $taxonomy) : ?>
            <label for="<?php echo $field->get_id($taxonomy->name) ?>">
                <?php echo $field->_output_option($value, $field->default_value, $taxonomy->name); ?>
                <?php echo $taxonomy->labels->singular_name; ?>
            </label>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
