<?php 

    $listCounter = 1;

?>

<?php if ($this->documentListCollection): ?>
    <?php foreach($this->chunkItems($this->items, 3) as $collection) { ?>
        <div class="document-list-collection">
            <?php foreach($collection as $documentList) { ?>
                <ul class="document-list">
                    <?php foreach($documentList['items'] as $item) { ?>
                        <li class="document-list--item">
                            <?php if ($item['title']): ?>
                                <p class="document-list--item-title" data-id="<?= $listCounter ?>">
                                    <?= $item['title'] ?>
                                </p>
                            <?php elseif ($item['link']): ?>
                                <a href="<?= $item['link']['url'] ?>" class="document-list--item-link">
                                    <?php $item['link']['title'] ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php $listCounter++; ?>
            <?php } ?>
        </div>
    <?php } ?>
<?php else: ?>
    <ul class="document-list">
        <?php foreach($this->items as $item) { ?>
            <li class="document-list--item">
                <?php if ($item['title']): ?>
                    <p class="document-list--item-title" data-id="<?= $listCounter ?>">
                        <?= $item['title'] ?>
                    </p>
                <?php elseif ($item['link']): ?>
                    <a href="<?= $item['link']['url'] ?>" class="document-list--item-link">
                        <?php $item['link']['title'] ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php } ?>
    </ul>
<?php endif; ?>