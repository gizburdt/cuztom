<div class="cuztom-sortable__item__control">
    <div class="cuztom-sortable__item__handle js-cuztom-sortable-item-handle">
        <a href="#" tabindex="-1"></a>
    </div>

    <div class="cuztom-sortable__item__remove">
        <a href="#" tabindex="-1" @click.prevent="removeItem(item)"></a>
    </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="form-table cuztom-table">
    <?php echo $item->outputFields(); ?>
</table>