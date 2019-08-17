<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend $emailSend
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Send'), ['action' => 'edit', $emailSend->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Send'), ['action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSend->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Sends'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Send'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Responses'), ['controller' => 'EmailResponses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Response'), ['controller' => 'EmailResponses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tokens'), ['controller' => 'Tokens', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Token'), ['controller' => 'Tokens', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailSends view large-9 medium-8 columns content">
    <h3><?= h($emailSend->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email Generation Code') ?></th>
            <td><?= h($emailSend->email_generation_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email Template') ?></th>
            <td><?= h($emailSend->email_template) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Message Send Code') ?></th>
            <td><?= h($emailSend->message_send_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $emailSend->has('user') ? $this->Html->link($emailSend->user->username, ['controller' => 'Users', 'action' => 'view', $emailSend->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($emailSend->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Routing Domain') ?></th>
            <td><?= h($emailSend->routing_domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('From Address') ?></th>
            <td><?= h($emailSend->from_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Friendly From') ?></th>
            <td><?= h($emailSend->friendly_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification') ?></th>
            <td><?= $emailSend->has('notification') ? $this->Html->link($emailSend->notification->id, ['controller' => 'Notifications', 'action' => 'view', $emailSend->notification->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailSend->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($emailSend->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($emailSend->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($emailSend->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sent') ?></th>
            <td><?= h($emailSend->sent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Include Token') ?></th>
            <td><?= $emailSend->include_token ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Email Responses') ?></h4>
        <?php if (!empty($emailSend->email_responses)): ?>
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
            <?php foreach ($emailSend->email_responses as $emailResponses): ?>
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
    <div class="related">
        <h4><?= __('Related Tokens') ?></h4>
        <?php if (!empty($emailSend->tokens)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Token') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Expires') ?></th>
                <th scope="col"><?= __('Utilised') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Email Send Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($emailSend->tokens as $tokens): ?>
            <tr>
                <td><?= h($tokens->id) ?></td>
                <td><?= h($tokens->token) ?></td>
                <td><?= h($tokens->created) ?></td>
                <td><?= h($tokens->modified) ?></td>
                <td><?= h($tokens->expires) ?></td>
                <td><?= h($tokens->utilised) ?></td>
                <td><?= h($tokens->active) ?></td>
                <td><?= h($tokens->deleted) ?></td>
                <td><?= h($tokens->email_send_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tokens', 'action' => 'view', $tokens->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tokens', 'action' => 'edit', $tokens->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tokens', 'action' => 'delete', $tokens->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tokens->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
