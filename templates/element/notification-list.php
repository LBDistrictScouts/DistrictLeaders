<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification[]|\Cake\Collection\CollectionInterface $notifications
 * @var mixed $index
 */

use App\Model\Entity\Notification;

?>
<thead>
    <tr>
        <?php if (isset($index) && $index) : ?>
            <th scope="col"><?= $this->Paginator->sort(Notification::FIELD_NOTIFICATION_TYPE_ID) ?></th>
            <th scope="col"><?= $this->Paginator->sort(Notification::FIELD_NOTIFICATION_HEADER) ?></th>
            <th scope="col">Actions</th>
            <th scope="col"><?= $this->Paginator->sort(Notification::FIELD_CREATED) ?></th>
            <th scope="col"><?= $this->Paginator->sort(Notification::FIELD_READ_DATE, 'Read') ?></th>
        <?php else : ?>
            <th scope="col">Notification Type</th>
            <th scope="col">Notification</th>
            <th scope="col">Actions</th>
            <th scope="col">Date Generated</th>
            <th scope="col">Read</th>
        <?php endif; ?>
    </tr>
</thead>
<tbody>
<?php foreach ($notifications as $notification) : ?>
    <tr>
        <?php $typeName = ($notification->has($notification::FIELD_NOTIFICATION_TYPE) ? $this->Icon->iconHtml($notification->notification_type->icon) . ' ' . $notification->notification_type->notification_type : '' ); ?>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'NotificationTypes') && $notification->has($notification::FIELD_NOTIFICATION_TYPE) ? $this->Html->link($typeName, ['controller' => 'NotificationTypes', 'action' => 'view', $notification->notification_type->id], ['title' => __('View Notification Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : $typeName ?></td>
        <td><?= h($notification->notification_header) ?></td>
        <?php $message = ($notification->has($notification::FIELD_USER) ? __('Are you sure you want send an email to {0} for this notification #{1}?', $notification->user->email, $notification->id) : __('Are you sure you want send an email for this notification #{0}?', $notification->id)); ?>
        <td class="actions">
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Notifications', 'action' => 'view', $notification->id], ['title' => __('View Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') && isset($index) && $index ? $this->Html->link('<i class="fal fa-user"></i>', ['controller' => 'Users', 'action' => 'view', $notification->user_id], ['title' => __('View User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'EmailSends') && $notification->has($notification::FIELD_EMAIL_SENDS) && count($notification->email_sends) >= 1 ? $this->Html->link('<i class="fal fa-envelope"></i>', ['controller' => 'EmailSends', 'action' => 'view', $notification->email_sends[0]->id], ['title' => __('View Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('CREATE', 'EmailSends') && $notification->has($notification::FIELD_EMAIL_SENDS) && count($notification->email_sends) < 1 ? $this->Form->postLink($this->Icon->iconHtml('inbox-out'), ['controller' => 'EmailSends', 'action' => 'make', $notification->id], ['confirm' => $message, 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Notifications') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $notification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notification->id), 'title' => __('Delete Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Time->format($notification->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Icon->iconBoolean(is_null($notification->read_date)) ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
