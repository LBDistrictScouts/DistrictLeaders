<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var integer $loggedInUserId
 * @var string $name
 */
?>
<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <?php if ( $this->Functional->checkFunction('directory') ) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Groups', ['controller' => 'ScoutGroups', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link('District Directory', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('documents')) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Documents', ['controller' => 'Documents', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('camps')) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Camps', ['controller' => 'Camps', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ( $this->Functional->checkFunction('articles') ) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
</ul>

<ul class="navbar-nav move-right mt-2 mt-lg-0">
    <li class="nav-item right-align mr-auto">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" id="notificationdwmb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fal fa-bell"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="notificationdwmb">
                <?= $this->Html->link('View Details', ['controller' => 'Users', 'action' => 'view', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
                <?= $this->Html->link('Edit Details', ['controller' => 'Users', 'action' => 'edit', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item'])  ?>
            </div>
        </div>
    </li>
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
</ul>
