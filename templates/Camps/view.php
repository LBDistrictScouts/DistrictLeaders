<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camp $camp
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Camp'), ['action' => 'edit', $camp->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Camp'), ['action' => 'delete', $camp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camp->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Camps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Camp Types'), ['controller' => 'CampTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp Type'), ['controller' => 'CampTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['controller' => 'CampRoles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp Role'), ['controller' => 'CampRoles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="camps view large-9 medium-8 columns content">
    <h3><?= h($camp->camp_name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Camp Name') ?></th>
            <td><?= h($camp->camp_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Camp Type') ?></th>
            <td><?= $camp->has('camp_type') ? $this->Html->link($camp->camp_type->camp_type, ['controller' => 'CampTypes', 'action' => 'view', $camp->camp_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($camp->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($camp->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($camp->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($camp->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Camp Start') ?></th>
            <td><?= h($camp->camp_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Camp End') ?></th>
            <td><?= h($camp->camp_end) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Camp Roles') ?></h4>
        <?php if (!empty($camp->camp_roles)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Camp Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Camp Role Type Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($camp->camp_roles as $campRoles) : ?>
            <tr>
                <td><?= h($campRoles->id) ?></td>
                <td><?= h($campRoles->created) ?></td>
                <td><?= h($campRoles->modified) ?></td>
                <td><?= h($campRoles->camp_id) ?></td>
                <td><?= h($campRoles->user_id) ?></td>
                <td><?= h($campRoles->camp_role_type_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CampRoles', 'action' => 'view', $campRoles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CampRoles', 'action' => 'edit', $campRoles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CampRoles', 'action' => 'delete', $campRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRoles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
