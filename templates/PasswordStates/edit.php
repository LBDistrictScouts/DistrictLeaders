<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PasswordState $passwordState
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $passwordState->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $passwordState->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Password States'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="passwordStates form large-9 medium-8 columns content">
    <?= $this->Form->create($passwordState) ?>
    <fieldset>
        <legend><?= __('Edit Password State') ?></legend>
        <?php
            echo $this->Form->control('password_state');
            echo $this->Form->control('active');
            echo $this->Form->control('expired');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
