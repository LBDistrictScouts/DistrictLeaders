<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification[]|\Cake\Collection\CollectionInterface $notifications
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Notifications');
$this->assign('subset', 'Your');
$this->assign('add', $this->Identity->checkCapability('CREATE_NOTIFICATION'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('new') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_header') ?></th>
        <th scope="col"><?= $this->Paginator->sort('text') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('read_date') ?></th>
        <th scope="col"><?= $this->Paginator->sort('notification_source') ?></th>
        <th scope="col"><?= $this->Paginator->sort('link_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('link_controller') ?></th>
        <th scope="col"><?= $this->Paginator->sort('link_prefix') ?></th>
        <th scope="col"><?= $this->Paginator->sort('link_action') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($notifications as $notification) : ?>
    <tr>
        <td><?= h($notification->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_NOTIFICATION') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $notification->id], ['title' => __('View Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_NOTIFICATION') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $notification->id], ['title' => __('Edit Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_NOTIFICATION') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $notification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notification->id), 'title' => __('Delete Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($notification->user_id) ?></td>
        <td><?= $this->Number->format($notification->notification_type_id) ?></td>
        <td><?= h($notification->new) ?></td>
        <td><?= h($notification->notification_header) ?></td>
        <td><?= h($notification->text) ?></td>
        <td><?= h($notification->created) ?></td>
        <td><?= h($notification->read_date) ?></td>
        <td><?= h($notification->notification_source) ?></td>
        <td><?= $this->Number->format($notification->link_id) ?></td>
        <td><?= h($notification->link_controller) ?></td>
        <td><?= h($notification->link_prefix) ?></td>
        <td><?= h($notification->link_action) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
