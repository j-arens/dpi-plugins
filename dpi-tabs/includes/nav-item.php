<a 
    href="#<?= rawurlencode($this->kebabCase($tab['title'])) ?>" 
    class="dpi-tab__nav-item <?= $i === 0 ? 'dpi-tab__nav-item-is-active' : '' ?>" 
    data-action="TOGGLE">
        <?= $tab['title'] ?>
</a>