<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleStatus $roleStatus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $roleStatus->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $roleStatus->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Role Statuses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="roleStatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($roleStatus) ?>
    <fieldset>
        <legend><?= __('Edit Role Status') ?></legend>
        <?php
            echo $this->Form->control('role_status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
