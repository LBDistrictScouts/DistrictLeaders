<?php
/**
 * @var AppView $this
 * @var QueuedJob $queuedJob
 */

use App\View\AppView;
use Queue\Model\Entity\QueuedJob;

$current = 'edit_data';

?>
<?= $this->element('header', ['data' => compact('current')]) ?>
<div class="row">
    <div class="col">
        <h1>Edit Data for Job <?= h($queuedJob->id) ?></h1>
        <?= $this->element('job', compact('current', 'queuedJob')) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= $this->Form->create($queuedJob) ?>
        <fieldset>
            <?= $this->Form->control('data', ['rows' => 20]) ?>
        </fieldset>
        <?= $this->Form->button(__d('queue', 'Submit'), ['class' => 'btn-lg btn-success btn-block']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
