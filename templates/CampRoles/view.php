<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRole $campRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Camp Role'), ['action' => 'edit', $campRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Camp Role'), ['action' => 'delete', $campRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Camps'), ['controller' => 'Camps', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp'), ['controller' => 'Camps', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Camp Role Types'), ['controller' => 'CampRoleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp Role Type'), ['controller' => 'CampRoleTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="campRoles view large-9 medium-8 columns content">
    <h3><?= h($campRole->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Camp') ?></th>
            <td><?= $campRole->has('camp') ? $this->Html->link($campRole->camp->camp_name, ['controller' => 'Camps', 'action' => 'view', $campRole->camp->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $campRole->has('user') ? $this->Html->link($campRole->user->full_name, ['controller' => 'Users', 'action' => 'view', $campRole->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Camp Role Type') ?></th>
            <td><?= $campRole->has('camp_role_type') ? $this->Html->link($campRole->camp_role_type->camp_role_type, ['controller' => 'CampRoleTypes', 'action' => 'view', $campRole->camp_role_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($campRole->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($campRole->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($campRole->modified) ?></td>
        </tr>
    </table>
</div>
