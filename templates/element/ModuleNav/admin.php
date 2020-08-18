<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 */
?>
<?php if ($this->Functional->checkFunction('admin', $this->Identity->get())) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Admin', 'action' => 'index', 'prefix' => false, 'plugin' => false])  ?>">Admin Dashboard</a>
<?php endif; ?>
<?php if ($this->Identity->checkCapability('ALL')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Queue', 'action' => 'index', 'prefix' => 'Admin', 'plugin' => 'Queue'])  ?>">Queue Dashboard</a>
<?php endif; ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Directories')) : ?>
    <a class="dropdown-item" role="presentation" href="<?= $this->Url->build(['controller' => 'Directories', 'action' => 'index', 'prefix' => false, 'plugin' => false])  ?>">Directories</a>
<?php endif; ?>
