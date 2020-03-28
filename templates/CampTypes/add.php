<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampType $campType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Camp Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Camps'), ['controller' => 'Camps', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp'), ['controller' => 'Camps', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="campTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($campType) ?>
    <fieldset>
        <legend><?= __('Add Camp Type') ?></legend>
        <?php
            echo $this->Form->control('camp_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
