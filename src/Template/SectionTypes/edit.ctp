<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SectionType $sectionType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sectionType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sectionType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Section Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Role Types'), ['controller' => 'RoleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role Type'), ['controller' => 'RoleTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sectionTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($sectionType) ?>
    <fieldset>
        <legend><?= __('Edit Section Type') ?></legend>
        <?php
            echo $this->Form->control('section_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
