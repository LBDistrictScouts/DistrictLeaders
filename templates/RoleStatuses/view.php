<?php
/**
 * @var AppView $this
 * @var RoleStatus $roleStatus
 */

use App\Model\Entity\RoleStatus;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role Status'), ['action' => 'edit', $roleStatus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role Status'), ['action' => 'delete', $roleStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleStatus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Role Statuses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Status'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roleStatuses view large-9 medium-8 columns content">
    <h3><?= h($roleStatus->role_status) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Role Status') ?></th>
            <td><?= h($roleStatus->role_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roleStatus->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Roles') ?></h4>
        <?php if (!empty($roleStatus->roles)) : ?>
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
            <?php foreach ($roleStatus->roles as $roles) : ?>
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
