<?php
/**
 * @var \App\View\AppView $this
 * @var integer $loggedInUserId
 */
?>

<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <?= $this->Html->link('Leaders', ['controller' => 'Pages', 'action' => 'display', 'home'], ['class' => 'navbar-brand'])  ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nToggle" aria-controls="nToggle" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nToggle">
        <ul class="navbar-nav">
            <?php if (isset($loggedInUserId)) : ?>
                <?php
                echo $this->cell('NavBar', [$loggedInUserId], [
                    'cache' => [
                            'config' => 'cell_cache',
                            'key' => 'nav_' . $loggedInUserId
                    ]
                ]); ?>
            <?php else: ?>
            <li class="nav-item">
                <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link'])  ?>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>