<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Section $section
 * @var mixed $scoutGroups
 * @var mixed $sectionTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Section Types'), ['controller' => 'SectionTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section Type'), ['controller' => 'SectionTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Scout Groups'), ['controller' => 'ScoutGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scout Group'), ['controller' => 'ScoutGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sections form large-9 medium-8 columns content">
    <?= $this->Form->create($section) ?>
    <fieldset>
        <legend><?= __('Add Section') ?></legend>
        <?php
            echo $this->Form->control('section');
            echo $this->Form->control('section_type_id', ['options' => $sectionTypes]);
            echo $this->Form->control('scout_group_id', ['options' => $scoutGroups]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
