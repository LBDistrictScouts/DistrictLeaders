<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRole[]|\Cake\Collection\CollectionInterface $campRoles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Camp Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camps'), ['controller' => 'Camps', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp'), ['controller' => 'Camps', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Role Types'), ['controller' => 'CampRoleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role Type'), ['controller' => 'CampRoleTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campRoles index large-9 medium-8 columns content">
    <h3><?= __('Camp Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_role_type_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($campRoles as $campRole): ?>
            <tr>
                <td><?= $this->Number->format($campRole->id) ?></td>
                <td><?= h($campRole->created) ?></td>
                <td><?= h($campRole->modified) ?></td>
                <td><?= $campRole->has('camp') ? $this->Html->link($campRole->camp->id, ['controller' => 'Camps', 'action' => 'view', $campRole->camp->id]) : '' ?></td>
                <td><?= $campRole->has('user') ? $this->Html->link($campRole->user->username, ['controller' => 'Users', 'action' => 'view', $campRole->user->id]) : '' ?></td>
                <td><?= $campRole->has('camp_role_type') ? $this->Html->link($campRole->camp_role_type->id, ['controller' => 'CampRoleTypes', 'action' => 'view', $campRole->camp_role_type->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $campRole->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $campRole->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRole->id)]) ?>
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
