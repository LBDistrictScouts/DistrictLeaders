<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'Users');
$this->assign('subset', 'All');
$this->assign('icon', 'fa-users');

?>

<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('full_name') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('membership_number') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('last_login') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= h($user->full_name) ?></td>
        <td class="actions">
		    <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $user->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
		    <?= $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $user->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
		    <?= $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
        <td><?= $this->Number->format($user->membership_number, ['pattern' => '#######']) ?></td>
        <td><?= $this->Time->i18nformat($user->created,'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->i18nformat($user->modified,'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->i18nformat($user->last_login,'dd-MMM-yy HH:mm') ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>
