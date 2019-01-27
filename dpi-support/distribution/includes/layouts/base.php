<?php

    $stylesheet = [
        'filepath' => plugin_dir_path(DPISUPPORT_ROOT) . '/styles/style.min.css',
        'url' => plugin_dir_url(DPISUPPORT_ROOT) . 'styles/style.min.css'
    ];

    $jsbundle = [
        'filepath' => plugin_dir_path(DPISUPPORT_ROOT) . '/js/bundle.min.js',
        'url' => plugin_dir_url(DPISUPPORT_ROOT) . 'js/bundle.min.js'
    ];

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie-edge">
        <title>DPI Docs <?= '| ' . $this->pageTitle ?></title>
        <meta name="description" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" href="#">
        <link rel="stylesheet" href="<?= $stylesheet['url'] . '?v=' . filemtime($stylesheet['filepath']); ?>">
    </head>
    <body class="<?= $this->bodyClass ?>">

        <!-- warn IE users to upgrade to a better browser -->
        <script type="text/javascript">
            if (!(window.ActiveXObject) && 'ActiveXObject' in window) {
                document.body.insertAdjacentHTML(
                    'afterbegin', 
                    '<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to view this site properly.<p>'
                );
            }
        </script>

        <noscript>
            <!--[if IE]>
                <div class="alert alert-warning">
                    'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
                </div>
            <![endif]-->
        </noscript>

        <!-- header -->
        <?= $this->partial(DPISUPPORT_DIR . '/includes/partials/header.php', [$this->headerType]); ?>
        <!-- /header -->

        <main class="l-main" role="main">
            <?= $this->yieldView(); ?>
        </main>

        <!-- footer -->
        <?= $this->partial(DPISUPPORT_DIR . '/includes/partials/footer.php', [$this->footerType]); ?>
        <!-- /footer -->

        <script type="text/javascript" src="<?= $jsbundle['url'] . '?v=' . filemtime($jsbundle['filepath']); ?>"></script>

    </body>
</html>