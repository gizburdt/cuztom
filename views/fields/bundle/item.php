<li class="cuztom-sortable-item js-cuztom-sortable-item">
    <div class="bundle-control">
        <div class="cuztom-sortable__handle js-cuztom-sortable-handle">
            <a href="#"></a>
        </div>

        <div class="cuztom-sortable__remove js-cuztom-remove-sortable"><a href="#"></a></div>
    </div>

    <fieldset class="cuztom-fieldset">
        <table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">
            <?php foreach ($item->data as $id => $field) : ?>
                <?php echo $field->outputRow(); ?>
            <?php endforeach; ?>
        </table>
    </fieldset>
</li>
