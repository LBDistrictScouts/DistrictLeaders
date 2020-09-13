<?php
/**
 * @var \App\View\AppView $this
 * @var string $system
 * @var string $creator
 */
?>
<div class="card thick-card">
    <div class="card-header">
        <h1>Welcome to the <?= $system ?></h1>
    </div>
    <div class="card-body">
        <?php if (isset($creator) && !empty($creator)) :
            ?><p>You have been added to the system by <?= $creator ?>.</p><?php
        endif; ?>
        <p><?= $this->element('system-description') ?></p>
        <p>Please proceed by setting your username and password below.</p>
    </div>
    <div class="card-footer">
        <?= $this->Html->link('Set your Username & Password', ['controller' => 'Users', 'action' => 'welcome'], ['class' => 'btn btn-success']) ?>
    </div>
</div>



