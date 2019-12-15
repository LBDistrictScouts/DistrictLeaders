<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $loggedInUser
 * @var mixed $identity
 */
?>
<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <?php if ($this->Functional->checkFunctionAuth('directory', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Groups', ['controller' => 'ScoutGroups', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link('District Directory', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('documents', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Documents', ['controller' => 'Documents', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('camps', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Camps', ['controller' => 'Camps', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
    <?php if ($this->Functional->checkFunctionAuth('articles', $identity)) : ?>
        <li class="nav-item">
            <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'index'], ['class' => 'nav-link'])  ?>
        </li>
    <?php endif; ?>
</ul>
