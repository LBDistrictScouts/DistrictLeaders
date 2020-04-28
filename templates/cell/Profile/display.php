<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var int $loggedInUserId
 * @var string $name
 */
?>
<?php if (isset($name)) : ?>
    <li class="nav-item right-align mr-auto">
        <a class="nav-link" data-toggle="modal" data-target="#profile">
            <i class="fal fa-user"></i> <?= h($name) ?>
        </a>
    </li>
<?php endif; ?>
