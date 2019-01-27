<div class="l-container__max-width">
    <?= $this->partial(DPISUPPORT_DIR . '/includes/partials/login-form.php', [$this->standardLoginPath, $this->nonce, $this->redirectUrl]) ?>
    <?= $this->partial(DPISUPPORT_DIR . '/includes/partials/contact-box.php') ?>
</div>