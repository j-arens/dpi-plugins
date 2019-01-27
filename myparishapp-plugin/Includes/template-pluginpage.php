<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div id="dpiPluginPage__root" class="wrap">
    <?= settings_errors() ?>
    <h1><?= $this->pageTitle ?></h1>
    <?php if(count($this->sections) > 1): ?>
        <h2 class="nav-tab-wrapper"><?= $this->renderNav($activeTab) ?></h2>
    <?php endif; ?>
    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php 
            do_settings_sections($activeTab);
            submit_button();
        ?>
    </form>
</div>