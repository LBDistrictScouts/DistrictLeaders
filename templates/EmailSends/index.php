<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend[]|\Cake\Collection\CollectionInterface $emailSends
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'EmailSends');
$this->assign('subset', 'All');
$this->assign('add', false);

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('email_generation_code') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_template') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('sent') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($emailSends as $emailSend) : ?>
    <tr>
        <td><?= h($emailSend->email_generation_code) ?></td>
        <td class="actions">
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'EmailSends') ? $this->Html->link('<i class="fal fa-envelope"></i>', ['action' => 'view', $emailSend->id], ['title' => __('View Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Notifications') ? $this->Html->link('<i class="fal fa-bell"></i>', ['controller' => 'Notifications', 'action' => 'view', $emailSend->notification_id], ['title' => __('View Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('DELETE', 'EmailSends') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSend->id), 'title' => __('Delete Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $emailSend->has('user') ? $this->Html->link($emailSend->user->full_name, ['controller' => 'Users', 'action' => 'view', $emailSend->user->id]) : '' ?></td>
        <td><?= $this->Inflection->space($emailSend->email_template) ?></td>
        <td><?= $this->Time->format($emailSend->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Icon->iconBoolean($emailSend->has('message_send_code')) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
