<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 */
?>
<nav class="navbar navbar-light navbar-expand-md text-white-50 bg-dark navigation-clean-search sticky-top">
    <div class="container"><?= $this->Html->link(__d('admin', 'Admin'), ['controller' => 'Admin', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'navbar-brand text-white-50']) ?>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav">
                <li class="nav-item" role="presentation"><?php echo $this->Html->link('Queue', ['controller' => 'Queue', 'action' => 'index', 'prefix' => 'Admin', 'plugin' => 'Queue'], ['class' => 'nav-link text-white-50']); ?></li>
                <li class="nav-item" role="presentation"><?php echo $this->Html->link('Directories', ['controller' => 'Directories', 'action' => 'index', 'prefix' => false, 'plugin' => false], ['class' => 'nav-link text-white-50']); ?></li>
            </ul>
        </div>
    </div>
</nav>

