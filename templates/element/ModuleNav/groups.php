<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'ScoutGroups', 'action' => 'index'])  ?>">Scout Groups</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('CREATE', 'ScoutGroups')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'ScoutGroups', 'action' => 'add']) ?>">Add Scout Group</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Sections')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Sections', 'action' => 'index'])  ?>">Sections</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('CREATE', 'Sections')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Sections', 'action' => 'add']) ?>">Add Section</a>
<?php endif; ?>
