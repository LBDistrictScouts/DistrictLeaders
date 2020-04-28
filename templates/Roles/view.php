<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Statuses'), ['controller' => 'RoleStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Status'), ['controller' => 'RoleStatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Contacts'), ['controller' => 'UserContacts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact'), ['controller' => 'UserContacts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Audits'), ['controller' => 'Audits', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Audit'), ['controller' => 'Audits', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roles view large-9 medium-8 columns content">
    <h3><?= h($role->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Role Type') ?></th>
            <td><?= $role->has('role_type') ? $this->Html->link($role->role_type->role_abbreviation, ['controller' => 'RoleTypes', 'action' => 'view', $role->role_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $role->has('section') ? $this->Html->link($role->section->section, ['controller' => 'Sections', 'action' => 'view', $role->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $role->has('user') ? $this->Html->link($role->user->full_name, ['controller' => 'Users', 'action' => 'view', $role->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role Status') ?></th>
            <td><?= $role->has('role_status') ? $this->Html->link($role->role_status->role_status, ['controller' => 'RoleStatuses', 'action' => 'view', $role->role_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Contact') ?></th>
            <td><?= $role->has('user_contact') ? $this->Html->link($role->user_contact->contact_field, ['controller' => 'UserContacts', 'action' => 'view', $role->user_contact->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($role->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($role->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($role->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($role->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Audits') ?></h4>
        <?php if (!empty($role->audits)) : ?>
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
            <?php foreach ($role->audits as $audits) : ?>
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
</div>
