<?php if ($type == 'accordion') : ?>
    <h3><?php echo $tab->title; ?></h3>
<?php endif; ?>

<div id="<?php echo $tab->get_id(); ?>">
    <?php if ($tab->fields instanceof Bundle) : ?>
        <?php echo $tab->fields->output($bundle->get_value()); ?>
    <?php else : ?>
        <table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">
            <?php foreach ($tab->fields as $id => $field) : ?>
                <?php echo $field->output_row(); ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
