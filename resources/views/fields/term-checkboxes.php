<div class="cuztom-checkboxes">
    <?php if (is_array($field->terms)) : ?>
        <?php foreach ($field->terms as $term) : ?>
            <label for="<?php echo $field->getId($term->term_id) ?>">
                <?php echo $field->outputOption($value, $field->default_value, $term->term_id); ?>
                <?php echo $term->name; ?>
            </label>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
