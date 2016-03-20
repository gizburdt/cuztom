<?php if (! empty($box->data)) : ?>
    <input type="hidden" name="cuztom[__activate]" value="activate">

    <div class="cuztom js-cuztom" data-box-id="<?php echo $box->id; ?>" data-object-id="'<?php echo $box->object; ?>" data-meta-type="<?php echo $box->meta_type; ?>">
        <?php if (! empty($box->description)) : ?>
            <div class="cuztom-box-description"><?php echo $box->description; ?></div>
        <?php endif; ?>

        <table class="form-table cuztom-table cuztom-main-table">
            <?php foreach ($box->data as $id => $field) : ?>
                <?php echo $field->output_row(); ?>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>
