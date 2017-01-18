<div class="cuztom-select-wrap">
    <select
        name="<?php echo $field->getName(); ?>"
        id="<?php echo $field->getId(); ?>"
        class="<?php echo $field->getCssClass(); ?>"
        <?php echo $field->getDataAttributes(); ?>
    >
        <?php echo $field->maybeShowOptionNone(); ?>

        <?php if (is_array($field->posts)) : ?>
            <?php foreach ($field->posts as $post) : ?>
                <option value="<?php echo $post->ID; ?>" <?php selected($post->ID, $value); ?>>
                    <?php echo $post->post_title; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
