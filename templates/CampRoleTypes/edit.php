<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRoleType $campRoleType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $campRoleType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $campRoleType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Camp Role Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['controller' => 'CampRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role'), ['controller' => 'CampRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campRoleTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($campRoleType) ?>
    <fieldset>
        <legend><?= __('Edit Camp Role Type') ?></legend>
        <?php
            echo $this->Form->control('camp_role_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
