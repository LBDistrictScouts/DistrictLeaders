<?php
/**
 * @var AppView $this
 * @var DirectoryGroup $directoryGroup
 */

use App\Model\Entity\DirectoryGroup;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Directory Group'), ['action' => 'edit', $directoryGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Directory Group'), ['action' => 'delete', $directoryGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Directory Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directories'), ['controller' => 'Directories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory'), ['controller' => 'Directories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="directoryGroups view large-9 medium-8 columns content">
    <h3><?= h($directoryGroup->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directory') ?></th>
            <td><?= $directoryGroup->has('directory') ? $this->Html->link($directoryGroup->directory->id, ['controller' => 'Directories', 'action' => 'view', $directoryGroup->directory->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Group Name') ?></th>
            <td><?= h($directoryGroup->directory_group_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Group Email') ?></th>
            <td><?= h($directoryGroup->directory_group_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Group Reference') ?></th>
            <td><?= h($directoryGroup->directory_group_reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($directoryGroup->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Role Types') ?></h4>
        <?php if (!empty($directoryGroup->role_types)) : ?>
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
            <?php foreach ($directoryGroup->role_types as $roleTypes) : ?>
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
