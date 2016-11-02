<?php

use Gizburdt\Cuztom\Cuztom;

?>

<div class="cuztom-checkboxes-wrap">
    <?php if (is_array($field->options)) : ?>
        <?php foreach ($field->options as $slug => $name) : ?>
            <label for="<?php echo $field->get_id(Cuztom::uglify($slug)); ?>">
                <?php echo $field->_output_option($value, $field->default_value, $slug); ?>
                <?php echo Cuztom::beautify($name); ?>
            </label>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
