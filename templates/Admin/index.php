<?php
/**
 * @var AppView $this
 * @var string $current
 * @var QueuedJob $queuedJob
 * @var bool $complete
 */

use App\View\AppView;
use Queue\Model\Entity\QueuedJob;

?>
<h3>Welcome Admin</h3>
<div class="card thick-card">
    <div class="card-body">
        <div class="btn-group" role="group" aria-label="Queue Toolbar">
            <?= $this->Form->postLink(
                'Process Capabilities',
                ['controller' => 'Capabilities', 'action' => 'process'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to trigger system Capability processing?'),
                    'role' => 'button',
                    'class' => 'btn btn-primary',
                ]
            ) ?>
            <?= $this->Form->postLink(
                'Process User States',
                ['controller' => 'UserStates', 'action' => 'process'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to trigger system User State processing?'),
                    'role' => 'button',
                    'class' => 'btn btn-primary',
                ]
            ) ?>
            <?= $this->Form->postLink(
                'Send Unsent Emails',
                ['controller' => 'EmailSends', 'action' => 'unsent'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to trigger unsent emails to be sent?'),
                    'role' => 'button',
                    'class' => 'btn btn-primary',
                ]
            ) ?>
            <?= $this->Form->postLink(
                'Parse Tokens for Activity',
                ['controller' => 'Tokens', 'action' => 'parse'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to trigger tokens to be evaluated for expiry?'),
                    'role' => 'button',
                    'class' => 'btn btn-primary',
                ]
            ) ?>
        </div>
    </div>
</div>

