<div class="cuztom-checkboxes-wrap">
    <?php if (is_array($field->posts)) : ?>
        <?php foreach ($field->posts as $post) : ?>
            <label for="<?php echo $field->get_id($post->ID) ?>">
                <?php echo $field->_output_option($value, $field->default_value, $post->ID); ?>
                <?php echo $post->post_title; ?>
            </label>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
