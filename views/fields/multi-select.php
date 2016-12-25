<div class="cuztom-select-wrap">
    <select
        name="<?php echo $field->getName(); ?>"
        id="<?php echo $field->getId(); ?>"
        class="<?php echo $field->getCssClass(); ?>"
        multiple="true"
        <?php echo $field->getDataAttributes(); ?>
    >
        <?php echo $field->maybeShowOptionNone(); ?>

        <?php if (is_array($field->options)) : ?>
            <?php foreach ($field->options as $slug => $name) : ?>
                <option value="<?php echo $slug; ?>" <?php echo is_array($value) ? (in_array($slug, $value) ? 'selected="selected"' : '') : ''; ?>>
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
