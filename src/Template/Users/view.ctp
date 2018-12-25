<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scout Groups'), ['controller' => 'ScoutGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scout Group'), ['controller' => 'ScoutGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Audits'), ['controller' => 'Audits', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Audit'), ['controller' => 'Audits', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Line 1') ?></th>
            <td><?= h($user->address_line_1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address Line 2') ?></th>
            <td><?= h($user->address_line_2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($user->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('County') ?></th>
            <td><?= h($user->county) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Postcode') ?></th>
            <td><?= h($user->postcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Scout Group') ?></th>
            <td><?= $user->has('scout_group') ? $this->Html->link($user->scout_group->id, ['controller' => 'ScoutGroups', 'action' => 'view', $user->scout_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Membership Number') ?></th>
            <td><?= $this->Number->format($user->membership_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Login') ?></th>
            <td><?= h($user->last_login) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Audits') ?></h4>
        <?php if (!empty($user->audits)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Audit Field') ?></th>
                <th scope="col"><?= __('Audit Table') ?></th>
                <th scope="col"><?= __('Original Value') ?></th>
                <th scope="col"><?= __('Modified Value') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Change Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->audits as $audits): ?>
            <tr>
                <td><?= h($audits->id) ?></td>
                <td><?= h($audits->audit_field) ?></td>
                <td><?= h($audits->audit_table) ?></td>
                <td><?= h($audits->original_value) ?></td>
                <td><?= h($audits->modified_value) ?></td>
                <td><?= h($audits->user_id) ?></td>
                <td><?= h($audits->change_date) ?></td>
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
        <?php if (!empty($user->roles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Role Type Id') ?></th>
                <th scope="col"><?= __('Section Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Role Status Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->roles as $roles): ?>
            <tr>
                <td><?= h($roles->id) ?></td>
                <td><?= h($roles->role_type_id) ?></td>
                <td><?= h($roles->section_id) ?></td>
                <td><?= h($roles->user_id) ?></td>
                <td><?= h($roles->role_status_id) ?></td>
                <td><?= h($roles->created) ?></td>
                <td><?= h($roles->modified) ?></td>
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
