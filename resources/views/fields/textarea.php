<textarea
    name="<?php echo $field->getName(); ?>"
    id="<?php echo $field->getId(); ?>"
    class="<?php echo $field->getCssClass(); ?>"
    <?php echo $field->getDataAttributes(); ?>
    ><?php echo $value; ?>
</textarea>