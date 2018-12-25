<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup $scoutGroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Scout Group'), ['action' => 'edit', $scoutGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Scout Group'), ['action' => 'delete', $scoutGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scoutGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Scout Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scout Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="scoutGroups view large-9 medium-8 columns content">
    <h3><?= h($scoutGroup->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Scout Group') ?></th>
            <td><?= h($scoutGroup->scout_group) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group Alias') ?></th>
            <td><?= h($scoutGroup->group_alias) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group Domain') ?></th>
            <td><?= h($scoutGroup->group_domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($scoutGroup->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Stripped') ?></th>
            <td><?= $this->Number->format($scoutGroup->number_stripped) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Charity Number') ?></th>
            <td><?= $this->Number->format($scoutGroup->charity_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($scoutGroup->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($scoutGroup->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Sections') ?></h4>
        <?php if (!empty($scoutGroup->sections)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Section') ?></th>
                <th scope="col"><?= __('Section Type Id') ?></th>
                <th scope="col"><?= __('Scout Group Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($scoutGroup->sections as $sections): ?>
            <tr>
                <td><?= h($sections->id) ?></td>
                <td><?= h($sections->section) ?></td>
                <td><?= h($sections->section_type_id) ?></td>
                <td><?= h($sections->scout_group_id) ?></td>
                <td><?= h($sections->created) ?></td>
                <td><?= h($sections->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sections', 'action' => 'view', $sections->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sections', 'action' => 'edit', $sections->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sections', 'action' => 'delete', $sections->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sections->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
