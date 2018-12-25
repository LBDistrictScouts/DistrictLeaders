<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Audit[]|\Cake\Collection\CollectionInterface $audits
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Audit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="audits index large-9 medium-8 columns content">
    <h3><?= __('Audits') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('audit_field') ?></th>
                <th scope="col"><?= $this->Paginator->sort('audit_table') ?></th>
                <th scope="col"><?= $this->Paginator->sort('original_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('change_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($audits as $audit): ?>
            <tr>
                <td><?= $this->Number->format($audit->id) ?></td>
                <td><?= h($audit->audit_field) ?></td>
                <td><?= h($audit->audit_table) ?></td>
                <td><?= h($audit->original_value) ?></td>
                <td><?= h($audit->modified_value) ?></td>
                <td><?= $audit->has('user') ? $this->Html->link($audit->user->id, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
                <td><?= h($audit->change_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $audit->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $audit->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $audit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->id)]) ?>
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
