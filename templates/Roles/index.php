<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Roles');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_ROLE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_status_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_contact_id') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roles as $role): ?>
    <tr>
        <td><?= h($role->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_ROLE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $role->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $role->id], ['title' => __('Edit Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($role->role_type_id) ?></td>
        <td><?= $this->Number->format($role->section_id) ?></td>
        <td><?= $this->Number->format($role->user_id) ?></td>
        <td><?= $this->Number->format($role->role_status_id) ?></td>
        <td><?= h($role->created) ?></td>
        <td><?= h($role->modified) ?></td>
        <td><?= $this->Number->format($role->user_contact_id) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
