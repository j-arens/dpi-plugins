<noscript>You need to enable JavaScript to properly view this component. If you're unsure of what to do, <a href="http://www.enable-javascript.com/" target="_blank" rel="noopener">click here</a> to learn more.</noscript>
<div id="<?= 'dpi-tab-' . static::$instance ?>" class="dpi-tab__root" role="presentation">
    <nav class="dpi-tab__nav">
        <?= $this->createTabComponent($views['nav-item'], $tabs) ?>
    </nav>
    <ul class="dpi-tab__tabs">
    <?= $this->createTabComponent($views['tab'], $tabs) ?>
    </ul>
</div>
<script type="text/javascript">
    if (!window.hasOwnProperty('DpiTabQueue')) window.DpiTabQueue = [];
    window.DpiTabQueue.push({selector: '#dpi-tab-<?= static::$instance ?>', config: <?= json_encode($config) ?>})
</script>