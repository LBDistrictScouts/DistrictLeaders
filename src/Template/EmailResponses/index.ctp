<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponse[]|\Cake\Collection\CollectionInterface $emailResponses
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Email Response'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Email Sends'), ['controller' => 'EmailSends', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Send'), ['controller' => 'EmailSends', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Email Response Types'), ['controller' => 'EmailResponseTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Response Type'), ['controller' => 'EmailResponseTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailResponses index large-9 medium-8 columns content">
    <h3><?= __('Email Responses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_send_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_response_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('link_clicked') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ip_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bounce_reason') ?></th>
                <th scope="col"><?= $this->Paginator->sort('message_size') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailResponses as $emailResponse): ?>
            <tr>
                <td><?= $this->Number->format($emailResponse->id) ?></td>
                <td><?= $emailResponse->has('email_send') ? $this->Html->link($emailResponse->email_send->id, ['controller' => 'EmailSends', 'action' => 'view', $emailResponse->email_send->id]) : '' ?></td>
                <td><?= h($emailResponse->deleted) ?></td>
                <td><?= $emailResponse->has('email_response_type') ? $this->Html->link($emailResponse->email_response_type->id, ['controller' => 'EmailResponseTypes', 'action' => 'view', $emailResponse->email_response_type->id]) : '' ?></td>
                <td><?= h($emailResponse->created) ?></td>
                <td><?= h($emailResponse->received) ?></td>
                <td><?= h($emailResponse->link_clicked) ?></td>
                <td><?= h($emailResponse->ip_address) ?></td>
                <td><?= h($emailResponse->bounce_reason) ?></td>
                <td><?= $this->Number->format($emailResponse->message_size) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailResponse->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailResponse->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailResponse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponse->id)]) ?>
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
