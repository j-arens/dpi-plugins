<div class="myparish-home-feed">
    <div class="myparish-home-feed-wrap">
        <div class="myparish-home-feed-app">
            <div class="myparish-icon-wrapper">
                <a href="" target="_blank" rel="noopener">
                    <?= @file_get_contents(MYPARISHAPP_DIR . '/assets/icons/mpa-icon.svg') ?>
                </a>
            </div>
            <div class="icon_wrapper">
                <div class="apple-icon-wrapper">
                    <a href="https://itunes.apple.com/us/app/myparish-catholic-life-every/id892066479?mt=8" target="_blank" rel="noopener">
                        <?= @file_get_contents(MYPARISHAPP_DIR . '/assets/icons/apple-icon.svg') ?>
                    </a>
                </div>
                <div class="android-icon-wrapper">
                    <a href="https://play.google.com/store/apps/details?id=com.michiganlabs.myparish" target="_blank" rel="noopener">
                        <?= @file_get_contents(MYPARISHAPP_DIR . '/assets/icons/android-icon.svg') ?>
                    </a>
                </div>
            </div>
            <a href="<?= $this->args['deep_link'] ?: 'https://myparishapp.net/' ?>" target="_blank" rel="noopener">
                Download Our App
            </a>
        </div>
        <div id="slider">
            <span class="my_parish_control_prev">
                <?= @file_get_contents(MYPARISHAPP_DIR . '/assets/icons/arrow-prev.svg') ?>
            </span>
            <ul class="dpi_mpa_messages_container">
                <?php foreach($this->messages as $message): ?>
                    <li>
                        <div class="dpi_mpa_message">
                            <span class="dpi_mpa_message_date">
                                <?= date('n/d/y g:ia', strtotime($message->post_date)) ?>
                            </span>
                            <span class="dpi_mpa_message_text">
                                <?= wp_trim_words($message->post_content, 10, '...') ?>
                            </span>
                            <span class="dpi_mpa_message_link">
                                <a href="<?= get_permalink($message) ?>">View Message</a>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <span class="my_parish_control_next">
                <?= @file_get_contents(MYPARISHAPP_DIR . '/assets/icons/arrow-next.svg') ?>
            </span>
        </div>
    </div>
</div>