<input
    type="<?php echo $field->getInputType(); ?>"
    name="<?php echo $field->getName(); ?>"
    id="<?php echo $field->getId(); ?>"
    class="<?php echo $field->getCssClass(); ?>"
    value="<?php echo $value; ?>"
    <?php echo $field->getDataAttributes(); ?>
>