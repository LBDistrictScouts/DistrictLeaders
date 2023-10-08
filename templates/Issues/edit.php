<?php
/**
 * @var AppView $this
 * @var Camp $camp
 * @var mixed $campTypes
 */

use App\Model\Entity\Camp;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $camp->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $camp->id)]
        )
                            ?></li>
        <li><?= $this->Html->link(__('List Camps'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Camp Types'), ['controller' => 'CampTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Type'), ['controller' => 'CampTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Camp Roles'), ['controller' => 'CampRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Camp Role'), ['controller' => 'CampRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="camps form large-9 medium-8 columns content">
    <?= $this->Form->create($camp) ?>
    <fieldset>
        <legend><?= __('Edit Camp') ?></legend>
        <?php
            echo $this->Form->control('deleted');
            echo $this->Form->control('camp_name');
            echo $this->Form->control('camp_type_id', ['options' => $campTypes]);
            echo $this->Form->control('camp_start');
            echo $this->Form->control('camp_end');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
