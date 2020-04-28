<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRoleType[]|\Cake\Collection\CollectionInterface $campRoleTypes
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'CampRoleTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_CAMP_ROLE_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('camp_role_type') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($campRoleTypes as $campRoleType) : ?>
    <tr>
        <td><?= h($campRoleType->camp_role_type) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_CAMP_ROLE_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $campRoleType->id], ['title' => __('View Camp Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_CAMP_ROLE_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $campRoleType->id], ['title' => __('Edit Camp Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_CAMP_ROLE_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $campRoleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRoleType->id), 'title' => __('Delete Camp Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($campRoleType->created) ?></td>
        <td><?= h($campRoleType->modified) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
