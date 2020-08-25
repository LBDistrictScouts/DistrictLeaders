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
<?php if (isset($queuedJob) && $queuedJob instanceof \Queue\Model\Entity\QueuedJob) : ?>
<div class="card thick-card">
    <div class="card-body">
        <div class="btn-group" role="group" aria-label="Queue Toolbar">
            <?= $current != 'view_job' ? $this->Html->link('View', ['controller' => 'QueuedJobs', 'action' => 'view', $queuedJob->id], [
                'role' => 'button',
                'class' => 'btn btn-outline-primary',
            ]) : '' ?>
            <?= $current != 'edit_job' && !$queuedJob->completed ? $this->Html->link('Edit', ['controller' => 'QueuedJobs', 'action' => 'edit', $queuedJob->id], [
                'role' => 'button',
                'class' => 'btn btn-outline-primary',
            ]) : '' ?>
            <?= $this->Html->link('Export', ['controller' => 'QueuedJobs', 'action' => 'view', $queuedJob->id, '_ext' => 'json', '?' => ['download' => true]], [
                'role' => 'button',
                'class' => 'btn btn-outline-primary',
            ]) ?>
            <?= $current != 'edit_data' && !$queuedJob->completed ? $this->Html->link('Edit Data', ['controller' => 'QueuedJobs', 'action' => 'data', $queuedJob->id], [
                'role' => 'button',
                'class' => 'btn btn-outline-primary',
            ]) : '' ?>
            <?= $this->Form->postLink(
                'Delete Queued Job',
                ['controller' => 'QueuedJobs', 'action' => 'delete', $queuedJob->id],
                [
                    'confirm' => __d('queue', 'Are you sure you want to delete job # {0}?', $queuedJob->id),
                    'role' => 'button',
                    'class' => 'btn btn-outline-danger',
                ]
            ) ?>
        </div>
    </div>
</div>
<?php endif; ?>

