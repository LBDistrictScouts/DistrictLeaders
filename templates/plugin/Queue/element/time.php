<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\I18n\FrozenTime;
?>
<div class="col d-flex justify-content-end">
    <?= __d('queue', 'Current server time') ?>:
    <?= $this->Time->nice(new FrozenTime()) ?>
</div>
