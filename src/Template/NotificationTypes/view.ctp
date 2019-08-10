<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotificationType $notificationType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notification Type'), ['action' => 'edit', $notificationType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notification Type'), ['action' => 'delete', $notificationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notificationType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notification Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notificationTypes view large-9 medium-8 columns content">
    <h3><?= h($notificationType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Notification Type') ?></th>
            <td><?= h($notificationType->notification_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Description') ?></th>
            <td><?= h($notificationType->notification_description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($notificationType->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Code') ?></th>
            <td><?= h($notificationType->type_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notificationType->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Notifications') ?></h4>
        <?php if (!empty($notificationType->notifications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Notification Type Id') ?></th>
                <th scope="col"><?= __('New') ?></th>
                <th scope="col"><?= __('Notification Header') ?></th>
                <th scope="col"><?= __('Text') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Read Date') ?></th>
                <th scope="col"><?= __('Notification Source') ?></th>
                <th scope="col"><?= __('Link Id') ?></th>
                <th scope="col"><?= __('Link Controller') ?></th>
                <th scope="col"><?= __('Link Prefix') ?></th>
                <th scope="col"><?= __('Link Action') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($notificationType->notifications as $notifications): ?>
            <tr>
                <td><?= h($notifications->id) ?></td>
                <td><?= h($notifications->user_id) ?></td>
                <td><?= h($notifications->notification_type_id) ?></td>
                <td><?= h($notifications->new) ?></td>
                <td><?= h($notifications->notification_header) ?></td>
                <td><?= h($notifications->text) ?></td>
                <td><?= h($notifications->created) ?></td>
                <td><?= h($notifications->read_date) ?></td>
                <td><?= h($notifications->notification_source) ?></td>
                <td><?= h($notifications->link_id) ?></td>
                <td><?= h($notifications->link_controller) ?></td>
                <td><?= h($notifications->link_prefix) ?></td>
                <td><?= h($notifications->link_action) ?></td>
                <td><?= h($notifications->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Notifications', 'action' => 'view', $notifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Notifications', 'action' => 'edit', $notifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Notifications', 'action' => 'delete', $notifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notifications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
