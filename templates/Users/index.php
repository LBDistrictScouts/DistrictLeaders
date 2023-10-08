<?php
/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 */
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Users');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->buildAndCheckCapability('CREATE', 'Users'));

?>

<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_FULL_NAME) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_EMAIL) ?></th>
        <th scope="col">Section(s)</th>
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
        <td><?= $this->Text->autoLinkEmails($user->email) ?></td>
        <td>
            <?php foreach ($user->roles as $role) : ?>
                <span class="badge badge-secondary"><?= $role->section->section ?></span>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
