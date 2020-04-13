<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notification'), ['action' => 'edit', $notification->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notification'), ['action' => 'delete', $notification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notification->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notifications'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notification Types'), ['controller' => 'NotificationTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification Type'), ['controller' => 'NotificationTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Sends'), ['controller' => 'EmailSends', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Send'), ['controller' => 'EmailSends', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notifications view large-9 medium-8 columns content">
    <h3><?= h($notification->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $notification->has('user') ? $this->Html->link($notification->user->full_name, ['controller' => 'Users', 'action' => 'view', $notification->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Type') ?></th>
            <td><?= $notification->has('notification_type') ? $this->Html->link($notification->notification_type->id, ['controller' => 'NotificationTypes', 'action' => 'view', $notification->notification_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Header') ?></th>
            <td><?= h($notification->notification_header) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Text') ?></th>
            <td><?= h($notification->text) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Source') ?></th>
            <td><?= h($notification->notification_source) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Controller') ?></th>
            <td><?= h($notification->link_controller) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Prefix') ?></th>
            <td><?= h($notification->link_prefix) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Action') ?></th>
            <td><?= h($notification->link_action) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notification->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Id') ?></th>
            <td><?= $this->Number->format($notification->link_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($notification->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Read Date') ?></th>
            <td><?= h($notification->read_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($notification->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New') ?></th>
            <td><?= $notification->new ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Email Sends') ?></h4>
        <?php if (!empty($notification->email_sends)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email Generation Code') ?></th>
                <th scope="col"><?= __('Email Template') ?></th>
                <th scope="col"><?= __('Include Token') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Sent') ?></th>
                <th scope="col"><?= __('Message Send Code') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Subject') ?></th>
                <th scope="col"><?= __('Routing Domain') ?></th>
                <th scope="col"><?= __('From Address') ?></th>
                <th scope="col"><?= __('Friendly From') ?></th>
                <th scope="col"><?= __('Notification Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($notification->email_sends as $emailSends): ?>
            <tr>
                <td><?= h($emailSends->id) ?></td>
                <td><?= h($emailSends->email_generation_code) ?></td>
                <td><?= h($emailSends->email_template) ?></td>
                <td><?= h($emailSends->include_token) ?></td>
                <td><?= h($emailSends->created) ?></td>
                <td><?= h($emailSends->modified) ?></td>
                <td><?= h($emailSends->deleted) ?></td>
                <td><?= h($emailSends->sent) ?></td>
                <td><?= h($emailSends->message_send_code) ?></td>
                <td><?= h($emailSends->user_id) ?></td>
                <td><?= h($emailSends->subject) ?></td>
                <td><?= h($emailSends->routing_domain) ?></td>
                <td><?= h($emailSends->from_address) ?></td>
                <td><?= h($emailSends->friendly_from) ?></td>
                <td><?= h($emailSends->notification_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmailSends', 'action' => 'view', $emailSends->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailSends', 'action' => 'edit', $emailSends->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailSends', 'action' => 'delete', $emailSends->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSends->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
