<div class="cuztom-radios">
    <?php foreach (array('yes', 'no') as $answer) : ?>
        <label for="<?php echo $field->get_id($answer); ?>">
            <?php echo $field->_output_option($value, $field->default_value, $answer); ?>
            <?php echo ($answer == 'yes' ? __('Yes', 'cuztom') : __('No', 'cuztom')); ?>
        </label>
        <br />
    <?php endforeach; ?>
</div>
