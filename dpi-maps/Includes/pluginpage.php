<div id="dpi-maps-settings-page" class="wrap">
    <?= settings_errors() ?>
    <h1>DPI Maps</h1>
    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php
            do_settings_sections('dpi-maps-settings');
            submit_button();
        ?>
    </form>
</div>