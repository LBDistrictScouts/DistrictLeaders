<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Scout Groups'), ['controller' => 'ScoutGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scout Group'), ['controller' => 'ScoutGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Audits'), ['controller' => 'Audits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Audit'), ['controller' => 'Audits', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('membership_number');
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('address_line_1');
            echo $this->Form->control('address_line_2');
            echo $this->Form->control('city');
            echo $this->Form->control('county');
            echo $this->Form->control('postcode');
            echo $this->Form->control('admin_scout_group_id', ['options' => $scoutGroups, 'empty' => true]);
            echo $this->Form->control('last_login');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
