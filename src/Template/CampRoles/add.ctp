<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRole $campRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Camps'), ['controller' => 'Camps', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp'), ['controller' => 'Camps', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Role Types'), ['controller' => 'CampRoleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role Type'), ['controller' => 'CampRoleTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campRoles form large-9 medium-8 columns content">
    <?= $this->Form->create($campRole) ?>
    <fieldset>
        <legend><?= __('Add Camp Role') ?></legend>
        <?php
            echo $this->Form->control('camp_id', ['options' => $camps]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('camp_role_type_id', ['options' => $campRoleTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
