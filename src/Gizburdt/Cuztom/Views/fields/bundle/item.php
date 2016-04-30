<li class="cuztom-sortable-item js-cuztom-sortable-item">
    <div class="bundle-control">
        <div class="cuztom-handle-sortable js-cuztom-handle-sortable">
            <a href="#"></a>
        </div>

        <div class="cuztom-remove-sortable js-cuztom-remove-sortable"><a href="#"></a></div>
    </div>

    <fieldset class="cuztom-fieldset">
        <table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">
            <?php foreach ($item->fields as $id => $field) : ?>
                <?php echo $field->output_row($value); ?>
            <?php endforeach; ?>
        </table>
    </fieldset>
</li>
