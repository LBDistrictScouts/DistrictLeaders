<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Notifications'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notification Types'), ['controller' => 'NotificationTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notification Type'), ['controller' => 'NotificationTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Email Sends'), ['controller' => 'EmailSends', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Send'), ['controller' => 'EmailSends', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notifications form large-9 medium-8 columns content">
    <?= $this->Form->create($notification) ?>
    <fieldset>
        <legend><?= __('Add Notification') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('notification_type_id', ['options' => $notificationTypes, 'empty' => true]);
            echo $this->Form->control('new');
            echo $this->Form->control('notification_header');
            echo $this->Form->control('text');
            echo $this->Form->control('read_date');
            echo $this->Form->control('notification_source');
            echo $this->Form->control('link_id');
            echo $this->Form->control('link_controller');
            echo $this->Form->control('link_prefix');
            echo $this->Form->control('link_action');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
