<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotificationType $notificationType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Notification Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notificationTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($notificationType) ?>
    <fieldset>
        <legend><?= __('Add Notification Type') ?></legend>
        <?php
            echo $this->Form->control('notification_type');
            echo $this->Form->control('notification_description');
            echo $this->Form->control('icon');
            echo $this->Form->control('type_code');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
