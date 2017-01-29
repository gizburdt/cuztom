<div class="cuztom-checkboxes">
    <?php if (is_array($field->taxonomies)) : ?>
        <?php foreach ($field->taxonomies as $taxonomy) : ?>
            <label for="<?php echo $field->getId($taxonomy->name) ?>">
                <?php echo $field->outputOption($value, $field->default_value, $taxonomy->name); ?>
                <?php echo $taxonomy->labels->singular_name; ?>
            </label>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
