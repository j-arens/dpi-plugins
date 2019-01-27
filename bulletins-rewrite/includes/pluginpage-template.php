<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div id="<?= $this->pageSlug ?>" class="wrap">
    <?= settings_errors() ?>
    <h1><?= $this->pageTitle ?></h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?= do_settings_sections($this->pageSlug) ?>
        <?= submit_button() ?>
    </form>
    <hr>
    <h3>Shortcodes</h3>
    <p>Bulletin Shortcode: [bulletins]</p>
    <p>Cover shortcode: [bulletin_cover]</p>
    <hr>
    <h3>Shortcode Parameters - Will override settings set in the plugin page.</h3>
    <ul>
        <li>"id" - Master list bulletin ID</li>
        <li>"quantity" - Number of bulletins to display. Max is 10.</li>
        <li>"title" - Label of the bulletin, will be the published date of the bulletin if left blank.</li>
    </ul>
    <hr>
    <h3>Getting the raw data</h3>
    <p>In some cases it's easier to work with a raw array bulletins instead of using the shortcodes or widget.</p>
    <pre style="background-color: darkslategrey">
        <code style="background: none; color: yellowgreen;">
            <span style="color: orangered">$Controller</span> = Bulletins\Plugin\Controller::getInstance();
            <span style="color: orangered">$bulletinID</span> = $Controller->getBulletinID();
            <span style="color: orangered">$bulletins</span> = $Controller->Transport->getBulletins($bulletinID, 10);
            
            <span style="color: #ddd">
                // $bulletins will be an array of arrays where each item represents a bulletin:
                //
                // Array(
                //    [07-30-2017.pdf] => Array(
                //        'date' => '2017-07-30',
                //        'links' => Array(
                //            'bulletin' => '//link to bulletin pdf',
                //            'cover' => '//link to bulletin cover'
                //        )
                //    ),
                //    [07-23-2017.pdf] => Array(
                //        'date' => '2017-07-23',
                //        'links' => Array(
                //            'bulletin' => '//link to bulletin pdf',
                //            'cover' => '//link to bulletin cover'
                //        )
                //    ),
                //    etc...
                // );
                //
                // In the case that there is an error or the $bulletinID is not valid $Controller->Transport->getBulletins() will return false.
            </span>
        </code>
    </pre>
</div>