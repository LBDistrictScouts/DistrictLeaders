<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType[]|\Cake\Collection\CollectionInterface $roleTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Role Type'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Section Types'), ['controller' => 'SectionTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section Type'), ['controller' => 'SectionTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="roleTypes index large-9 medium-8 columns content">
    <h3><?= __('Role Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_abbreviation') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_type_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roleTypes as $roleType): ?>
            <tr>
                <td><?= $this->Number->format($roleType->id) ?></td>
                <td><?= h($roleType->role_type) ?></td>
                <td><?= h($roleType->role_abbreviation) ?></td>
                <td><?= $roleType->has('section_type') ? $this->Html->link($roleType->section_type->id, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $roleType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roleType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $roleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleType->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
