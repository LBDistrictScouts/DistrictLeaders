<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponseType $emailResponseType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Response Type'), ['action' => 'edit', $emailResponseType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Response Type'), ['action' => 'delete', $emailResponseType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponseType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Response Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Response Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Responses'), ['controller' => 'EmailResponses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Response'), ['controller' => 'EmailResponses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailResponseTypes view large-9 medium-8 columns content">
    <h3><?= h($emailResponseType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email Response Type') ?></th>
            <td><?= h($emailResponseType->email_response_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailResponseType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bounce') ?></th>
            <td><?= $emailResponseType->bounce ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Email Responses') ?></h4>
        <?php if (!empty($emailResponseType->email_responses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email Send Id') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Email Response Type Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Received') ?></th>
                <th scope="col"><?= __('Link Clicked') ?></th>
                <th scope="col"><?= __('Ip Address') ?></th>
                <th scope="col"><?= __('Bounce Reason') ?></th>
                <th scope="col"><?= __('Message Size') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($emailResponseType->email_responses as $emailResponses): ?>
            <tr>
                <td><?= h($emailResponses->id) ?></td>
                <td><?= h($emailResponses->email_send_id) ?></td>
                <td><?= h($emailResponses->deleted) ?></td>
                <td><?= h($emailResponses->email_response_type_id) ?></td>
                <td><?= h($emailResponses->created) ?></td>
                <td><?= h($emailResponses->received) ?></td>
                <td><?= h($emailResponses->link_clicked) ?></td>
                <td><?= h($emailResponses->ip_address) ?></td>
                <td><?= h($emailResponses->bounce_reason) ?></td>
                <td><?= h($emailResponses->message_size) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmailResponses', 'action' => 'view', $emailResponses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailResponses', 'action' => 'edit', $emailResponses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailResponses', 'action' => 'delete', $emailResponses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
