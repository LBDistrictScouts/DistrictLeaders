<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $identity
 */
?>
<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <?php if ($this->Functional->checkFunctionAuth('directory', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Groups', ['controller' => 'ScoutGroups', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link('District Directory', ['controller' => 'Users', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('documents', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Documents', ['controller' => 'Documents', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('camps', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Camps', ['controller' => 'Camps', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('articles', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('admin', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Admin', ['controller' => 'Admin', 'action' => 'home', 'prefix' => 'Admin', 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
</ul>
