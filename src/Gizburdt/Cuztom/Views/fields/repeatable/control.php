<div class="cuztom-control">
    <a class="cuztom-button cuztom-add-sortable js-cuztom-add-sortable button button-secondary button-small" data-sortable-type="repeatable" data-field-id="<?php echo $field->get_id(); ?>" href="#">
        <?php _e('Add item', 'cuztom'); ?>
    </a>
    
    <?php if ($field->limit) : ?>
        <div class="cuztom-counter js-cuztom-counter">
            <span class="current js-current"><?php echo $count; ?></span>
            <span class="divider"> / </span>
            <span class="max js-max"><?php echo $field->limit; ?></span>
        </div>
    <?php endif; ?>
</div>
