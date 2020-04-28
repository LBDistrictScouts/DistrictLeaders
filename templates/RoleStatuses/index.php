<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleStatus[]|\Cake\Collection\CollectionInterface $roleStatuses
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'RoleStatuses');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_ROLE_STATUS'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('role_status') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roleStatuses as $roleStatus) : ?>
    <tr>
        <td><?= h($roleStatus->role_status) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_ROLE_STATUS') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $roleStatus->id], ['title' => __('View Role Status'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_ROLE_STATUS') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $roleStatus->id], ['title' => __('Edit Role Status'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_ROLE_STATUS') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $roleStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleStatus->id), 'title' => __('Delete Role Status'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
