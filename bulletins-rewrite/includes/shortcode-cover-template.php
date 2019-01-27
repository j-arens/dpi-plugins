<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="dpi_bulletin_cover_wrapper">
    <?php if (!empty($bulletin)): ?>
        <span class="dpi_bulletin_cover_date">
            <?= date("F jS, Y", strtotime($bulletin['date'])) ?>
        </span>
        <br>
        <a href="<?= $bulletin['links']['bulletin'] ?>" target="_blank" rel="noopener">
            <img class='dpi_bulletin_cover' src="<?= $bulletin['links']['cover'] ?>" alt="Bulletin Cover" />
        </a>
    <?php else: ?>
        <p class="dpi_bulletin_empty">DPI Bulletins Plugin: Sorry, there aren't any bulletins to show you right now.</p>
    <?php endif; ?>
</div>