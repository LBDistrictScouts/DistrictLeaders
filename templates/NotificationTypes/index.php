<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotificationType[]|\Cake\Collection\CollectionInterface $notificationTypes
 */

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'NotificationTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_NOTIFICATION_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_description') ?></th>
        <th scope="col"><?= $this->Paginator->sort('icon') ?></th>
        <th scope="col"><?= $this->Paginator->sort('type_code') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($notificationTypes as $notificationType): ?>
    <tr>
        <td><?= h($notificationType->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_NOTIFICATION_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $notificationType->id], ['title' => __('View Notification Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_NOTIFICATION_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $notificationType->id], ['title' => __('Edit Notification Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_NOTIFICATION_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $notificationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notificationType->id), 'title' => __('Delete Notification Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($notificationType->notification_type) ?></td>
        <td><?= h($notificationType->notification_description) ?></td>
        <td><?= h($notificationType->icon) ?></td>
        <td><?= h($notificationType->type_code) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>