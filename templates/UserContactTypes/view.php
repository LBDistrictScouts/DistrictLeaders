<?php
/**
 * @var AppView $this
 * @var UserContactType $userContactType
 */

use App\Model\Entity\UserContactType;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Contact Type'), ['action' => 'edit', $userContactType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Contact Type'), ['action' => 'delete', $userContactType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContactType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Contact Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Contacts'), ['controller' => 'UserContacts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact'), ['controller' => 'UserContacts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userContactTypes view large-9 medium-8 columns content">
    <h3><?= h($userContactType->user_contact_type) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User Contact Type') ?></th>
            <td><?= h($userContactType->user_contact_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($userContactType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($userContactType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($userContactType->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related User Contacts') ?></h4>
        <?php if (!empty($userContactType->user_contacts)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Contact Field') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('User Contact Type Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Verified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($userContactType->user_contacts as $userContacts) : ?>
            <tr>
                <td><?= h($userContacts->id) ?></td>
                <td><?= h($userContacts->contact_field) ?></td>
                <td><?= h($userContacts->user_id) ?></td>
                <td><?= h($userContacts->user_contact_type_id) ?></td>
                <td><?= h($userContacts->created) ?></td>
                <td><?= h($userContacts->modified) ?></td>
                <td><?= h($userContacts->verified) ?></td>
                <td><?= h($userContacts->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserContacts', 'action' => 'view', $userContacts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserContacts', 'action' => 'edit', $userContacts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserContacts', 'action' => 'delete', $userContacts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContacts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
