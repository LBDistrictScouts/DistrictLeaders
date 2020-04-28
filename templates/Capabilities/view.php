<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Capability $capability
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Capability'), ['action' => 'edit', $capability->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Capability'), ['action' => 'delete', $capability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $capability->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Capabilities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Capability'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="capabilities view large-9 medium-8 columns content">
    <h3><?= h($capability->capability_code) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Capability Code') ?></th>
            <td><?= h($capability->capability_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Capability') ?></th>
            <td><?= h($capability->capability) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($capability->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Min Level') ?></th>
            <td><?= $this->Number->format($capability->min_level) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Role Types') ?></h4>
        <?php if (!empty($capability->role_types)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Role Type') ?></th>
                <th scope="col"><?= __('Role Abbreviation') ?></th>
                <th scope="col"><?= __('Section Type Id') ?></th>
                <th scope="col"><?= __('Level') ?></th>
                <th scope="col"><?= __('Role Template Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($capability->role_types as $roleTypes) : ?>
            <tr>
                <td><?= h($roleTypes->id) ?></td>
                <td><?= h($roleTypes->role_type) ?></td>
                <td><?= h($roleTypes->role_abbreviation) ?></td>
                <td><?= h($roleTypes->section_type_id) ?></td>
                <td><?= h($roleTypes->level) ?></td>
                <td><?= h($roleTypes->role_template_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RoleTypes', 'action' => 'view', $roleTypes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RoleTypes', 'action' => 'edit', $roleTypes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RoleTypes', 'action' => 'delete', $roleTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleTypes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
