<div class="cuztom-select-wrap">
    <select
        name="<?php echo $field->getName(); ?>"
        id="<?php echo $field->getId(); ?>"
        class="<?php echo $field->getCssClass(); ?>"
        <?php echo $field->getDataAttributes(); ?>
    >
        <?php echo $field->maybeShowOptionNone(); ?>

        <?php if (is_array($field->taxonomies)) : ?>
            <?php foreach ($field->taxonomies as $taxonomy) : ?>

                <option value="<?php echo $taxonomy->name; ?>" <?php selected($taxonomy->name, $value); ?>>
                    <?php echo $taxonomy->labels->singular_name; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
