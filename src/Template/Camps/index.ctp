<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camp[]|\Cake\Collection\CollectionInterface $camps
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Camp'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Types'), ['controller' => 'CampTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Type'), ['controller' => 'CampTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['controller' => 'CampRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role'), ['controller' => 'CampRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="camps index large-9 medium-8 columns content">
    <h3><?= __('Camps') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('camp_end') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($camps as $camp): ?>
            <tr>
                <td><?= $this->Number->format($camp->id) ?></td>
                <td><?= h($camp->created) ?></td>
                <td><?= h($camp->modified) ?></td>
                <td><?= h($camp->deleted) ?></td>
                <td><?= h($camp->camp_name) ?></td>
                <td><?= $camp->has('camp_type') ? $this->Html->link($camp->camp_type->id, ['controller' => 'CampTypes', 'action' => 'view', $camp->camp_type->id]) : '' ?></td>
                <td><?= h($camp->camp_start) ?></td>
                <td><?= h($camp->camp_end) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $camp->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $camp->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $camp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camp->id)]) ?>
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
