<?php if ($args['type'] == 'accordion') : ?>
    <h3><?php echo $tab->title; ?></h3>
<?php endif; ?>

<div id="<?php echo $tab->get_id(); ?>">
    <?php if ($tab->fields instanceof Bundle) : ?>
        <?php $bundle = $tab->fields; ?>
        <?php echo $bundle->output($bundle->get_value()); ?>
    <?php else : ?>
        <table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">
            <?php
                foreach ($tab->fields as $id => $field) :
                    if (! $field instanceof Hidden) :
                        echo $field->output_row($field->get_value());
                    else :
                        echo $field->output($field->get_value());
                    endif;
                endforeach;
            ?>
        </table>
    <?php endif; ?>
</div>

<?php $ob = ob_get_clean(); return $ob;
