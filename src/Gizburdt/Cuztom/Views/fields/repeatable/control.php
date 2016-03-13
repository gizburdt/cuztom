<div class="cuztom-control">
    <a class="button-secondary button button-small cuztom-button js-cztm-add-sortable" href="#" data-sortable-type="repeatable" data-field-id="<?php echo $field->get_id(); ?>"><?php _e('Add item', 'cuztom'); ?></a>
    <?php if ($field->limit) : ?>
        <div class="cuztom-counter js-cztm-counter">
            <span class="current js-current"><?php echo count($value); ?></span>
            <span class="divider"> / </span>
            <span class="max js-max"><?php echo $field->limit; ?></span>
        </div>
    <?php endif; ?>
</div>
