<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend[]|\Cake\Collection\CollectionInterface $emailSends
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'EmailSends');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_EMAIL_SEND'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_generation_code') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_template') ?></th>
        <th scope="col"><?= $this->Paginator->sort('include_token') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('sent') ?></th>
        <th scope="col"><?= $this->Paginator->sort('message_send_code') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
        <th scope="col"><?= $this->Paginator->sort('routing_domain') ?></th>
        <th scope="col"><?= $this->Paginator->sort('from_address') ?></th>
        <th scope="col"><?= $this->Paginator->sort('friendly_from') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_id') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($emailSends as $emailSend) : ?>
    <tr>
        <td><?= h($emailSend->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_EMAIL_SEND') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $emailSend->id], ['title' => __('View Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_EMAIL_SEND') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $emailSend->id], ['title' => __('Edit Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_EMAIL_SEND') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSend->id), 'title' => __('Delete Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($emailSend->email_generation_code) ?></td>
        <td><?= h($emailSend->email_template) ?></td>
        <td><?= h($emailSend->include_token) ?></td>
        <td><?= h($emailSend->created) ?></td>
        <td><?= h($emailSend->modified) ?></td>
        <td><?= h($emailSend->sent) ?></td>
        <td><?= h($emailSend->message_send_code) ?></td>
        <td><?= $this->Number->format($emailSend->user_id) ?></td>
        <td><?= h($emailSend->subject) ?></td>
        <td><?= h($emailSend->routing_domain) ?></td>
        <td><?= h($emailSend->from_address) ?></td>
        <td><?= h($emailSend->friendly_from) ?></td>
        <td><?= $this->Number->format($emailSend->notification_id) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
