<li id="<?= rawurlencode($this->kebabCase($tab['title'])) ?>" class="dpi-tab__tab <?= $i === 0 ? 'dpi-tab__tab-is-active' : '' ?>">
    <a href="#<?= rawurlencode($this->kebabCase($title['title'])) ?>" class="dpi-tab__mobile-toggle" data-action="TOGGLE">
        <?= $tab['title'] ?>
    </a>
    <div class="dpi-tab__content">
        <?php
            if ($tab['template'] && file_exists($tab['template'])) {
                include $tab['template'];
            } else {
                echo apply_filters('the_content', $tab['content']);
            }
        ?>
    </div>
</li>