<?php
/**
 * @var AppView $this
 * @var Token $token
 */

use App\Model\Entity\Token;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tokens'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tokens form large-9 medium-8 columns content">
    <?= $this->Form->create($token) ?>
    <fieldset>
        <legend><?= __('Add Token') ?></legend>
        <?php
            echo $this->Form->control('token');
            echo $this->Form->control('expires');
            echo $this->Form->control('utilised');
            echo $this->Form->control('active');
            echo $this->Form->control('deleted');
            echo $this->Form->control('hash');
            echo $this->Form->control('random_number');
            echo $this->Form->control('token_header');
            echo $this->Form->control('email_send_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
