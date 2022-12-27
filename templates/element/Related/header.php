<?php
/**
 * @var AppView $this
 * @var User $user
 */
declare(strict_types=1);

/**
 * @var AppView $this
 * @var User $user
 */

use App\Model\Entity\User;
use App\View\AppView;

?>
<div class="card text-center">
    <div class="card-header">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <?php if (!empty($user->roles)) : ?>
                <a class="flex-sm-fill text-sm-center nav-link"
                   data-toggle="collapse"
                   href="#roles"
                   role="button"
                   aria-expanded="false"
                   aria-controls="roles">
                    User Roles
                </a>
            <?php endif; ?>
            <?php if (!empty($user->audits)) : ?>
                <a class="flex-sm-fill text-sm-center nav-link"
                   data-toggle="collapse"
                   href="#recordChanges"
                   role="button"
                   aria-expanded="false"
                   aria-controls="recordChanges">
                    Changes to User Record
                </a>
            <?php endif; ?>
            <?php if (!empty($user->changes)) : ?>
                <a class="flex-sm-fill text-sm-center nav-link"
                   data-toggle="collapse"
                   href="#recentChanges"
                   role="button"
                   aria-expanded="false"
                   aria-controls="recentChanges">
                    Recent Changes made by User
                </a>
            <?php endif; ?>
        </nav>
    </div>
</div>
