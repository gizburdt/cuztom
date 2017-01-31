<input type="hidden" name="cuztom[__activate]" value="activate">
<input type="hidden" name="cuztom[object]" value="<?php echo $box->object; ?>">

<div class="cuztom cuztom--<?php echo $box->metaType; ?> v-cuztom">
    <?php if (! empty($box->description)) : ?>
        <div class="cuztom__description"><?php echo $box->description; ?></div>
    <?php endif; ?>

    <?php if (! empty($box->data)) : ?>
        <div class="cuztom__content">
            <table class="form-table cuztom-table cuztom-main">
                <?php foreach ($box->data as $id => $field) : ?>
                    <?php echo $field->outputCell(); ?>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
</div>