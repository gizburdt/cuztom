<table border="0" cellpadding="0" cellspacing="0" class="form-table cuztom-table">
    <?php foreach ($item->data as $field) : ?>
        <?php echo $field->outputCell(); ?>
    <?php endforeach; ?>
</table>