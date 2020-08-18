<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $identity
 */
?>
<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <?php if ($this->Functional->checkFunction('directory', $identity)) : ?>
        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: #7413db;font-family: 'Nunito Sans', sans-serif;">Groups</a>
            <div class="dropdown-menu" role="menu">
                <?= $this->element('ModuleNav/groups') ?>
            </div>
        </li>
        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: #7413db;font-family: 'Nunito Sans', sans-serif;">District Directory</a>
            <div class="dropdown-menu" role="menu">
                <?= $this->element('ModuleNav/directory') ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('documents', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Documents', ['controller' => 'Documents', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('camps', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Camps', ['controller' => 'Camps', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('articles', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunction('admin', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Admin', ['controller' => 'Admin', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
</ul>
