<?php
/**
 * @var \App\View\AppView $this
 * @var string $current
 * @var int $job_id
 */

if (!isset($current)) {
    $current = '';
}

?>
<div class="col">
    <div class="btn-group" role="group" aria-label="Queue Toolbar">
        <?= $current != 'dashboard' ? $this->Html->link('Queue Dashboard', ['controller' => 'Queue', 'action' => 'index'], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
        <?= $current != 'index' ? $this->Html->link('Job Index', ['controller' => 'QueuedJobs', 'action' => 'index'], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
        <?= $current != 'import' && $this->Configure->read('debug') ? $this->Html->link('Import Jobs', ['controller' => 'QueuedJobs', 'action' => 'import'], [
            'role' => 'button',
            'class' => 'btn btn-secondary',
        ]) : '' ?>
    </div>
</div>

