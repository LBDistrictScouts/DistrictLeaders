<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType[]|\Cake\Collection\CollectionInterface $roleTypes
 * @var \App\Model\Entity\User $authUser
 */

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'RoleTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_ROLE_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('role_abbreviation') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('section_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('level') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_template_id') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roleTypes as $roleType): ?>
    <tr>
        <td><?= h($roleType->role_abbreviation) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_ROLE_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $roleType->id], ['title' => __('View Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_ROLE_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $roleType->id], ['title' => __('Edit Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_ROLE_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $roleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleType->id), 'title' => __('Delete Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($roleType->role_type) ?></td>
        <td><?= $roleType->has('section_type') ? $this->Html->link($roleType->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : '' ?></td>
        <td><?= $this->Number->format($roleType->level) ?></td>
        <td><?= $roleType->has('role_template') ? $this->Html->link($roleType->role_template->role_template, ['controller' => 'RoleTemplates', 'action' => 'view', $roleType->role_template->id]) : '' ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
