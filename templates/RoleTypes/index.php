<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType[]|\Cake\Collection\CollectionInterface $roleTypes
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'RoleTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->buildAndCheckCapability('CREATE', 'RoleTypes'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('role_abbreviation') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('level') ?></th>
        <th scope="col"><?= $this->Paginator->sort('section_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('role_template_id') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roleTypes as $roleType) : ?>
    <tr>
        <td><?= h($roleType->role_abbreviation) ?></td>
                <td class="actions">
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'RoleTypes') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $roleType->id], ['title' => __('View Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'RoleTypes') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $roleType->id], ['title' => __('Edit Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('DELETE', 'RoleTypes') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $roleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleType->id), 'title' => __('Delete Role Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($roleType->role_type) ?></td>
        <td><?= $this->Number->format($roleType->level) ?></td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'SectionTypes') ? $this->Html->link($roleType->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : h($roleType->section_type->section_type) ?></td>
        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'RoleTemplates') ? $this->Html->link($roleType->role_template->role_template, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->role_template->id]) : h($roleType->role_template->role_template) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
