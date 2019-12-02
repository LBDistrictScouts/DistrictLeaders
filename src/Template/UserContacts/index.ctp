<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact[]|\Cake\Collection\CollectionInterface $userContacts
 */
?>
<div class="userContacts index large-9 medium-8 columns content">
    <h3><?= __('User Contacts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contact_field') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_contact_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('verified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userContacts as $userContact): ?>
            <tr>
                <td><?= $this->Number->format($userContact->id) ?></td>
                <td><?= h($userContact->contact_field) ?></td>
                <td><?= $userContact->has('user') ? $this->Html->link($userContact->user->username, ['controller' => 'Users', 'action' => 'view', $userContact->user->id]) : '' ?></td>
                <td><?= $userContact->has('user_contact_type') ? $this->Html->link($userContact->user_contact_type->id, ['controller' => 'UserContactTypes', 'action' => 'view', $userContact->user_contact_type->id]) : '' ?></td>
                <td><?= h($userContact->created) ?></td>
                <td><?= h($userContact->modified) ?></td>
                <td><?= h($userContact->verified) ?></td>
                <td><?= h($userContact->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userContact->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userContact->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userContact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContact->id)]) ?>
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
