<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<p>
    <label for="<?= $this->get_field_id('title') ?>">Widget Title</label>
    <input 
        id="<?= $this->get_field_id('title') ?>" 
        name="<?= $this->get_field_name('title') ?>" 
        type="text" 
        value="<?= $title ?>"
        class="widefat" 
    />
</p>
<p>
    <label for="<?= $this->get_field_id('text') ?>">Text:</label>
    <input 
        id="<?= $this->get_field_id('text') ?>"
        name="<?= $this->get_field_name('text') ?>"
        type="text" 
        value="<?= $text ?>"
        class="widefat" 
    />
</p>
<p>
    <label for="<?= $this->get_field_id('bulletins') ?>">Bulletins:</label>
    <input 
        id="<?= $this->get_field_id('bulletins') ?>"
        name="<?= $this->get_field_name('bulletins') ?>"
        type="text" 
        value="<?= $bulletins ?>"
        maxlength="1"
        class="widefat" 
    />
</p>