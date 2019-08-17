<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend[]|\Cake\Collection\CollectionInterface $emailSends
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Email Send'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Email Responses'), ['controller' => 'EmailResponses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Response'), ['controller' => 'EmailResponses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tokens'), ['controller' => 'Tokens', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Token'), ['controller' => 'Tokens', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailSends index large-9 medium-8 columns content">
    <h3><?= __('Email Sends') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_generation_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_template') ?></th>
                <th scope="col"><?= $this->Paginator->sort('include_token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('message_send_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('routing_domain') ?></th>
                <th scope="col"><?= $this->Paginator->sort('from_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('friendly_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('notification_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailSends as $emailSend): ?>
            <tr>
                <td><?= $this->Number->format($emailSend->id) ?></td>
                <td><?= h($emailSend->email_generation_code) ?></td>
                <td><?= h($emailSend->email_template) ?></td>
                <td><?= h($emailSend->include_token) ?></td>
                <td><?= h($emailSend->created) ?></td>
                <td><?= h($emailSend->modified) ?></td>
                <td><?= h($emailSend->deleted) ?></td>
                <td><?= h($emailSend->sent) ?></td>
                <td><?= h($emailSend->message_send_code) ?></td>
                <td><?= $emailSend->has('user') ? $this->Html->link($emailSend->user->username, ['controller' => 'Users', 'action' => 'view', $emailSend->user->id]) : '' ?></td>
                <td><?= h($emailSend->subject) ?></td>
                <td><?= h($emailSend->routing_domain) ?></td>
                <td><?= h($emailSend->from_address) ?></td>
                <td><?= h($emailSend->friendly_from) ?></td>
                <td><?= $emailSend->has('notification') ? $this->Html->link($emailSend->notification->id, ['controller' => 'Notifications', 'action' => 'view', $emailSend->notification->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailSend->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailSend->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSend->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
