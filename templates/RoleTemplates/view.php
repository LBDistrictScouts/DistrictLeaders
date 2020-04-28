<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleTemplate $roleTemplate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role Template'), ['action' => 'edit', $roleTemplate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role Template'), ['action' => 'delete', $roleTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleTemplate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Role Templates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Template'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roleTemplates view large-9 medium-8 columns content">
    <h3><?= h($roleTemplate->role_template) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Role Template') ?></th>
            <td><?= h($roleTemplate->role_template) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Template Capabilities') ?></th>
            <td><?= h($roleTemplate->template_capabilities) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roleTemplate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Indicative Level') ?></th>
            <td><?= $this->Number->format($roleTemplate->indicative_level) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Role Types') ?></h4>
        <?php if (!empty($roleTemplate->role_types)) : ?>
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
            <?php foreach ($roleTemplate->role_types as $roleTypes) : ?>
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
