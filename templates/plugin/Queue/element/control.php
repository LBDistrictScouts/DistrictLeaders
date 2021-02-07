<?php
/**
 * @var \App\View\AppView $this
 * @var string $current
 * @var \Queue\Model\Entity\QueuedJob $queuedJob
 * @var bool $complete
 */

if (!isset($current)) {
    $current = '';
}

?>
<div class="card thick-card">
    <div class="card-body">
        <div class="btn-group" role="group" aria-label="Queue Toolbar">
            <?= $this->Form->postLink(
                'Re-queue Failed Jobs',
                ['controller' => 'Queue', 'action' => 'reset'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to re-queue jobs that have previously failed?'),
                    'role' => 'button',
                    'class' => 'btn btn-warning',
                ]
            ) ?>

            <?= $this->Form->postLink(
                'Cleanup Expired Processes',
                ['controller' => 'QueueProcesses', 'action' => 'cleanup'],
                [
                    'confirm' => 'Are you sure you want to remove all workers over default timeout?',
                    'role' => 'button',
                    'class' => 'btn btn-warning',
                ]
            ) ?>
            <?= Cake\Core\Configure::read('debug') ? $this->Html->link('Import Jobs', [
                'controller' => 'QueuedJobs',
                'action' => 'import',
            ], [
                'role' => 'button',
                'class' => 'btn btn-warning',
            ]) : '' ?>
            <?= $this->Form->postLink(
                'Truncate Job Queue',
                ['controller' => 'Queue', 'action' => 'hardReset'],
                [
                    'confirm' => __d('queue', 'Are you sure you want to clear all job records?'),
                    'role' => 'button',
                    'class' => 'btn btn-danger',
                ]
            ) ?>
        </div>
    </div>
</div>

