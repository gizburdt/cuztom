<div class="js-cuztom-accordion">
    <?php foreach ($field->tabs as $title => $tab) : ?>
        <?php echo $tab->output($args); ?>
    <?php endforeach; ?>
</div>
