<div class="js-cuztom-accordion">
    <?php foreach ($tabs->tabs as $title => $tab) : ?>
        <?php echo $tab->output($args); ?>
    <?php endforeach; ?>
</div>
