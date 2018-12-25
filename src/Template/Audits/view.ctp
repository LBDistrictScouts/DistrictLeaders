<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Audit $audit
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Audit'), ['action' => 'edit', $audit->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Audit'), ['action' => 'delete', $audit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Audits'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Audit'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="audits view large-9 medium-8 columns content">
    <h3><?= h($audit->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Audit Field') ?></th>
            <td><?= h($audit->audit_field) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Audit Table') ?></th>
            <td><?= h($audit->audit_table) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Original Value') ?></th>
            <td><?= h($audit->original_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified Value') ?></th>
            <td><?= h($audit->modified_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $audit->has('user') ? $this->Html->link($audit->user->id, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($audit->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Change Date') ?></th>
            <td><?= h($audit->change_date) ?></td>
        </tr>
    </table>
</div>
