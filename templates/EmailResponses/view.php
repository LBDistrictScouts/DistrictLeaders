<?php
/**
 * @var AppView $this
 * @var EmailResponse $emailResponse
 */

use App\Model\Entity\EmailResponse;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Response'), ['action' => 'edit', $emailResponse->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Response'), ['action' => 'delete', $emailResponse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponse->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Responses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Response'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Sends'), ['controller' => 'EmailSends', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Send'), ['controller' => 'EmailSends', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Response Types'), ['controller' => 'EmailResponseTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Response Type'), ['controller' => 'EmailResponseTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailResponses view large-9 medium-8 columns content">
    <h3><?= h($emailResponse->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email Send') ?></th>
            <td><?= $emailResponse->has('email_send') ? $this->Html->link($emailResponse->email_send->id, ['controller' => 'EmailSends', 'action' => 'view', $emailResponse->email_send->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email Response Type') ?></th>
            <td><?= $emailResponse->has('email_response_type') ? $this->Html->link($emailResponse->email_response_type->id, ['controller' => 'EmailResponseTypes', 'action' => 'view', $emailResponse->email_response_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Clicked') ?></th>
            <td><?= h($emailResponse->link_clicked) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip Address') ?></th>
            <td><?= h($emailResponse->ip_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bounce Reason') ?></th>
            <td><?= h($emailResponse->bounce_reason) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailResponse->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Message Size') ?></th>
            <td><?= $this->Number->format($emailResponse->message_size) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($emailResponse->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($emailResponse->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Received') ?></th>
            <td><?= h($emailResponse->received) ?></td>
        </tr>
    </table>
</div>
