<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContactType[]|\Cake\Collection\CollectionInterface $userContactTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User Contact Type'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Contacts'), ['controller' => 'UserContacts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Contact'), ['controller' => 'UserContacts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userContactTypes index large-9 medium-8 columns content">
    <h3><?= __('User Contact Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_contact_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userContactTypes as $userContactType): ?>
            <tr>
                <td><?= $this->Number->format($userContactType->id) ?></td>
                <td><?= h($userContactType->user_contact_type) ?></td>
                <td><?= h($userContactType->created) ?></td>
                <td><?= h($userContactType->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userContactType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userContactType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userContactType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContactType->id)]) ?>
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
