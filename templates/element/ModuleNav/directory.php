<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 */
?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Users') || $this->Identity->checkCapability('DIRECTORY')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index', 'prefix' => false, 'plugin' => false])  ?>">Members</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('CREATE', 'Users')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add'])  ?>">Add New User</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('CREATE', 'Roles')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Roles', 'action' => 'add'])  ?>">Add User Role</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'RoleTypes')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'RoleTypes', 'action' => 'index'])  ?>">List Users by Role Type</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'CompassRecords')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'CompassRecords', 'action' => 'index', 'prefix' => false, 'plugin' => false])  ?>">Compass Records</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('CREATE', 'CompassRecords')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Documents', 'action' => 'add', 'prefix' => false, 'plugin' => false])  ?>">Upload Compass Spreadsheet</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Directories')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Directories', 'action' => 'index', 'prefix' => false, 'plugin' => false])  ?>">Directories</a>
<?php endif; ?>

