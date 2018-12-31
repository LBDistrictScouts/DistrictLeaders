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
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('username') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('membership_number') ?></th>
        <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('last_login') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $this->Number->format($user->id) ?></td>
        <td><?= h($user->username) ?></td>
        <td class="actions">
		    <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $user->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
		    <?= $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $user->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
		    <?= $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
        <td><?= $this->Number->format($user->membership_number) ?></td>
        <td><?= h($user->first_name) ?></td>
        <td><?= h($user->last_name) ?></td>
        <td><?= h($user->email) ?></td>
        <td><?= h($user->created) ?></td>
        <td><?= h($user->modified) ?></td>
        <td><?= h($user->last_login) ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>
