<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContactType $userContactType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userContactType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userContactType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User Contact Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Contacts'), ['controller' => 'UserContacts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Contact'), ['controller' => 'UserContacts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userContactTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($userContactType) ?>
    <fieldset>
        <legend><?= __('Edit User Contact Type') ?></legend>
        <?php
            echo $this->Form->control('user_contact_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
