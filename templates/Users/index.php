<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
use App\Model\Entity\User;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Users');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_USER'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_FULL_NAME) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_MEMBERSHIP_NUMBER) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_CREATED) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_MODIFIED) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_LAST_LOGIN) ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td><?= h($user->full_name) ?></td>
        <td class="actions">
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users', $user->groups, $user->sections) ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $user->id], ['title' => __('View User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Users', $user->groups, $user->sections) ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $user->id], ['title' => __('Edit User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Users', $user->groups, $user->sections) ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users', $user->groups, $user->sections, $user::FIELD_MEMBERSHIP_NUMBER) ? $this->Number->format($user->membership_number, ['pattern' => '#######']) : '' ?></td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users', $user->groups, $user->sections, $user::FIELD_CREATED) ? $this->Time->format($user->created, 'dd-MMM-yy HH:mm') : '' ?></td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users', $user->groups, $user->sections, $user::FIELD_MODIFIED) ? $this->Time->format($user->modified, 'dd-MMM-yy HH:mm') : '' ?></td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users', $user->groups, $user->sections, $user::FIELD_LAST_LOGIN) ? $this->Time->format($user->last_login, 'dd-MMM-yy HH:mm') : '' ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>
