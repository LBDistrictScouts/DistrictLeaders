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
