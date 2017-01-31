<div class="js-cuztom-accordion">
    <?php foreach ($tabs->data as $title => $tab) : ?>
        <?php echo $tab->outputTab(); ?>
    <?php endforeach; ?>
</div>
