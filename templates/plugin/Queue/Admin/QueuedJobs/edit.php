<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob $queuedJob
 */
$current = 'edit_job';

?>
<?= $this->element('header', ['data' => compact('current')]) ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<div class="row">
    <div class="col">
        <h1>Edit Queued Job <?= h($queuedJob->id) ?></h1>
        <?= $this->element('job', compact('current', 'queuedJob')) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= $this->Form->create($queuedJob) ?>
        <fieldset>
            <?= $this->Form->dateTime('notbefore', ['empty' => true]) ?>
            <?= $this->Form->control('priority') ?>
        </fieldset>
        <?= $this->Form->button(__d('queue', 'Submit'), ['class' => 'btn-lg btn-success btn-block']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
