<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 * @var mixed $PolicyResult
 */
?>
<nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean">
    <div class="container">
        <?= $this->Html->link('Leaders', ['controller' => 'Pages', 'plugin' => false, 'prefix' => false, 'action' => 'display', 'home'], ['class' => 'navbar-brand'])  ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nToggle" aria-controls="nToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nToggle">
            <?php
            /** @var \Authentication\AuthenticationService $authAttr */
            $authAttr = $this->getRequest()->getAttribute('authentication');
            $result = $authAttr->getResult();
            /** @var \App\Model\Entity\User $identity */
            $identity = $this->getRequest()->getAttribute('identity');

            if ($result->isValid()) : ?>
                <?= $this->cell('NavBar', [$identity], [
                    'cache' => [
                        'config' => 'cell_cache',
                        'key' => 'nav_' . $identity->get('id'),
                    ],
                ])->render() ?>
                <?= $this->element('rightBar') ?>
            <?php else : ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link'])  ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>





