<?php if ($args['type'] == 'accordion') : ?>
    <h3><?php echo $tab->title; ?></h3>
<?php endif; ?>

<div id="<?php echo $tab->get_id(); ?>">
    <?php if ($fields instanceof Bundle) : ?>
        <?php echo $fields->output($field->value); ?>
    <?php else : ?>
        <table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">
            <?php
                foreach ($fields as $id => $field) :
                    if (! $field instanceof Hidden) :
                        echo $field->output_row($field->value);
                    else :
                        echo $field->output($field->value);
                    endif;
                endforeach;
            ?>
        </table>
    <?php endif; ?>
</div>

<?php $ob = ob_get_clean(); return $ob;
