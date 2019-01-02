<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Capability[]|\Cake\Collection\CollectionInterface $capabilities
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Capability'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="capabilities index large-9 medium-8 columns content">
    <h3><?= __('Capabilities') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('capability_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('capability') ?></th>
                <th scope="col"><?= $this->Paginator->sort('level') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($capabilities as $capability): ?>
            <tr>
                <td><?= $this->Number->format($capability->id) ?></td>
                <td><?= h($capability->capability_code) ?></td>
                <td><?= h($capability->capability) ?></td>
                <td><?= $this->Number->format($capability->level) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $capability->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $capability->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $capability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $capability->id)]) ?>
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
