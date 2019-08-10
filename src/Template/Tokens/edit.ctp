<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token $token
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $token->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $token->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tokens'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tokens form large-9 medium-8 columns content">
    <?= $this->Form->create($token) ?>
    <fieldset>
        <legend><?= __('Edit Token') ?></legend>
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
