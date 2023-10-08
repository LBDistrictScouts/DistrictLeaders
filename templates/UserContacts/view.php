<?php
/**
 * @var AppView $this
 * @var UserContact $userContact
 */

use App\Model\Entity\UserContact;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Contact'), ['action' => 'edit', $userContact->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Contact'), ['action' => 'delete', $userContact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContact->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Contacts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Contact Types'), ['controller' => 'UserContactTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact Type'), ['controller' => 'UserContactTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Audits'), ['controller' => 'Audits', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Audit'), ['controller' => 'Audits', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userContacts view large-9 medium-8 columns content">
    <h3><?= h($userContact->contact_field) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contact Field') ?></th>
            <td><?= h($userContact->contact_field) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $userContact->has('user') ? $this->Html->link($userContact->user->full_name, ['controller' => 'Users', 'action' => 'view', $userContact->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Contact Type') ?></th>
            <td><?= $userContact->has('user_contact_type') ? $this->Html->link($userContact->user_contact_type->user_contact_type, ['controller' => 'UserContactTypes', 'action' => 'view', $userContact->user_contact_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($userContact->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($userContact->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($userContact->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($userContact->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Verified') ?></th>
            <td><?= $userContact->verified ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Audits') ?></h4>
        <?php if (!empty($userContact->audits)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Audit Field') ?></th>
                <th scope="col"><?= __('Audit Table') ?></th>
                <th scope="col"><?= __('Original Value') ?></th>
                <th scope="col"><?= __('Modified Value') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Change Date') ?></th>
                <th scope="col"><?= __('Audit Record Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($userContact->audits as $audits) : ?>
            <tr>
                <td><?= h($audits->id) ?></td>
                <td><?= h($audits->audit_field) ?></td>
                <td><?= h($audits->audit_table) ?></td>
                <td><?= h($audits->original_value) ?></td>
                <td><?= h($audits->modified_value) ?></td>
                <td><?= h($audits->user_id) ?></td>
                <td><?= h($audits->change_date) ?></td>
                <td><?= h($audits->audit_record_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Audits', 'action' => 'view', $audits->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Audits', 'action' => 'edit', $audits->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Audits', 'action' => 'delete', $audits->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audits->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Roles') ?></h4>
        <?php if (!empty($userContact->roles)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Role Type Id') ?></th>
                <th scope="col"><?= __('Section Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Role Status Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('User Contact Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($userContact->roles as $roles) : ?>
            <tr>
                <td><?= h($roles->id) ?></td>
                <td><?= h($roles->role_type_id) ?></td>
                <td><?= h($roles->section_id) ?></td>
                <td><?= h($roles->user_id) ?></td>
                <td><?= h($roles->role_status_id) ?></td>
                <td><?= h($roles->created) ?></td>
                <td><?= h($roles->modified) ?></td>
                <td><?= h($roles->deleted) ?></td>
                <td><?= h($roles->user_contact_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
