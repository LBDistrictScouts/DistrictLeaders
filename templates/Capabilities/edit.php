<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Capability $capability
 * @var mixed $roleTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $capability->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $capability->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Capabilities'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="capabilities form large-9 medium-8 columns content">
    <?= $this->Form->create($capability) ?>
    <fieldset>
        <legend><?= __('Edit Capability') ?></legend>
        <?php
            echo $this->Form->control('capability_code');
            echo $this->Form->control('capability');
            echo $this->Form->control('min_level');
            echo $this->Form->control('role_types._ids', ['options' => $roleTypes, 'multiple' => 'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
