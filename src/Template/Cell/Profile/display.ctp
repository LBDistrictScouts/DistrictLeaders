<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var integer $loggedInUserId
 * @var string $name
 */
?>
<li class="nav-item right-align mr-auto">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-user"></i> <?= h($name) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?= $this->Html->link('View Details', ['controller' => 'Users', 'action' => 'view', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
            <?= $this->Html->link('Edit Details', ['controller' => 'Users', 'action' => 'edit', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
            <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item'])  ?>
        </div>
    </div>
</li>
