<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var int $loggedInUserId
 * @var string $name
 */
?>
<?= $this->Html->link('View Details', ['controller' => 'Users', 'action' => 'view', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
<?= $this->Html->link('View Permissions', ['controller' => 'Capabilities', 'action' => 'permissions', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
<?= $this->Html->link('Edit Details', ['controller' => 'Users', 'action' => 'edit', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
<?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'password', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
<div class="dropdown-divider"></div>
<?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item'])  ?>
