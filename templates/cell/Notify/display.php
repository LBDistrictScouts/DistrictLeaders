<?php
/**
 * @var AppView $this
 * @var int $loggedInUserId
 * @var int $notificationCount
 */

use App\View\AppView;

?>
<?php if ($notificationCount > 0) : ?>
<li class="nav-item right-align mr-auto">
    <a class="nav-link" data-toggle="modal" data-target="#notify">
        <?= $this->Icon->iconHtml('bell') ?>
        <?php if ($notificationCount > 1) : ?>
            <span class="badge badge-primary badge-pill"><?= $notificationCount ?></span>
        <?php endif; ?>
    </a>
</li>

<?php endif; ?>
