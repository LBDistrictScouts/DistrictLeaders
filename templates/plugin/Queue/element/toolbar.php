<?php
/**
 * @var AppView $this
 * @var string $current
 * @var int $job_id
 */

use App\View\AppView;

if (!isset($current)) {
    $current = '';
}

?>
<div class="col col-md-9">
    <div class="btn-group" role="group" aria-label="Queue Toolbar">
        <?= $current != 'dashboard' ? $this->Html->link('Queue Dashboard', [
            'controller' => 'Queue',
            'action' => 'index',
        ], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
        <?= $current != 'index' ? $this->Html->link('Job Index', [
            'controller' => 'QueuedJobs',
            'action' => 'index',
        ], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>

        <?= $current != 'processes' ? $this->Html->link('Processes Dashboard', [
            'controller' => 'Queue',
            'action' => 'processes',
        ], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
        <?= $current != 'process-list' ? $this->Html->link(__d('queue', 'List {0}', __d('queue', 'Queue Processes')), [
            'controller' => 'QueueProcesses',
            'action' => 'index',
        ], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
    </div>
</div>

