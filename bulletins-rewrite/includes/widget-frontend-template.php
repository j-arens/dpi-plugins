<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="widget-text wp_widget_plugin_box">
    <?php if (!empty($instance['title'])): ?>
        <?= apply_filters('widget_title', $instance['title']) ?>
    <?php endif; ?>
    <?php if (!empty($instance['text'])): ?>
        <p class="wp_widget_plugin_text"><?= $instance['text'] ?></p>
    <?php endif; ?>
    <?php if (!empty($bulletins)): ?>
        <?php foreach($bulletins as $bulletin) { ?>
            <a href="<?= $bulletin['links']['bulletin'] ?>" class="dpi_bulletin_widget_link" target="_blank" rel="noopener">
                <?= date('M j, Y', strtotime($bulletin['date'])) ?>
            </a>
            <br>
        <?php } ?>
    <?php else: ?>
        <p class="dpi_bulletin_empty">DPI Bulletins Widget: Sorry, there aren't any bulletins to show you right now.</p>
    <?php endif; ?>
</div>