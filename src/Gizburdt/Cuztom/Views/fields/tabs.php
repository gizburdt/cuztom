<div class="js-cuztom-tabs">
    <ul>
        <?php foreach ($tabs->tabs as $title => $tab) : ?>
            <li>
                <a href="#<?php echo $tab->get_id(); ?>">
                    <?php echo $tab->title; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php foreach ($tabs->tabs as $title => $tab) : ?>
        <?php echo $tab->output($args); ?>
    <?php endforeach; ?>
</div>
