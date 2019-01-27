<div id="myparishapp__root" class="myparishapp__container">
    <button class="myparishapp__control myparishapp__control-disabled" data-action="SLIDE_LEFT">
        <svg class="myparishapp__control-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75.6 57.9">
            <path d="M71.1 24.4H15.4L32.1 7.7c1.8-1.8 1.8-4.6 0-6.4 -1.8-1.8-4.6-1.8-6.4 0L1.3 25.7C0.5 26.6 0 27.7 0 28.9s0.5 2.3 1.3 3.2L25.8 56.5c0.9 0.9 2 1.3 3.2 1.3 1.2 0 2.3-0.4 3.2-1.3 1.8-1.8 1.8-4.6 0-6.4L15.4 33.4h55.8c2.5 0 4.5-2 4.5-4.5C75.6 26.4 73.6 24.4 71.1 24.4z"/>
        </svg>
    </button>
    <div class="myparishapp__slider-wrap">
        <div class="myparishapp__info">
            <p class="myparishapp__info-title">myParish App</p>
            <div class="myparishapp__info-icons">
                <?= $this->iconLinks() ?>
            </div>
            <a href="<?= $this->args['deep_link'] ? $this->args['deep_link'] : '//myparishapp.com/' ?>" class="myparishapp__info-link">
                Download Our App
            </a>
        </div>
        <ul class="myparishapp__messages">
            <?= $this->slides() ?>
        </ul>
    </div>
    <button class="myparishapp__control" data-action="SLIDE_RIGHT">
        <svg class="myparishapp__control-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75.6 57.9">
            <path d="M4.5 33.4h55.8L43.5 50.2c-1.8 1.8-1.8 4.6 0 6.4 1.8 1.8 4.6 1.8 6.4 0l24.4-24.4c0.8-0.8 1.3-2 1.3-3.2s-0.5-2.3-1.3-3.2L49.9 1.3C49 0.4 47.9 0 46.7 0s-2.3 0.4-3.2 1.3c-1.8 1.8-1.8 4.6 0 6.4L60.3 24.4H4.5c-2.5 0-4.5 2-4.5 4.5C0 31.4 2 33.4 4.5 33.4z"/>
        </svg>
    </button>
</div>