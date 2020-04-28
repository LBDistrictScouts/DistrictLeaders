<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PasswordState[]|\Cake\Collection\CollectionInterface $passwordStates
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Password State'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="passwordStates index large-9 medium-8 columns content">
    <h3><?= __('Password States') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password_state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expired') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($passwordStates as $passwordState) : ?>
            <tr>
                <td><?= $this->Number->format($passwordState->id) ?></td>
                <td><?= h($passwordState->password_state) ?></td>
                <td><?= h($passwordState->active) ?></td>
                <td><?= h($passwordState->expired) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $passwordState->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $passwordState->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $passwordState->id], ['confirm' => __('Are you sure you want to delete # {0}?', $passwordState->id)]) ?>
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
