<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRoleType[]|\Cake\Collection\CollectionInterface $campRoleTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Camp Role Type'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['controller' => 'CampRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role'), ['controller' => 'CampRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campRoleTypes index large-9 medium-8 columns content">
    <h3><?= __('Camp Role Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_role_type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($campRoleTypes as $campRoleType): ?>
            <tr>
                <td><?= $this->Number->format($campRoleType->id) ?></td>
                <td><?= h($campRoleType->created) ?></td>
                <td><?= h($campRoleType->modified) ?></td>
                <td><?= h($campRoleType->camp_role_type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $campRoleType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $campRoleType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campRoleType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRoleType->id)]) ?>
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
