<div class="js-cuztom-tabs">
    <ul>
        <?php foreach ($tabs->data as $title => $tab) : ?>
            <li>
                <a href="#<?php echo $tab->getId(); ?>">
                    <?php echo $tab->title; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php foreach ($tabs->data as $title => $tab) : ?>
        <?php echo $tab->outputTab(); ?>
    <?php endforeach; ?>
</div>
