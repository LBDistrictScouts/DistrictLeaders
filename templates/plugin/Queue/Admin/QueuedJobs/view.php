<?php
/**
 * @var \App\View\AppView $this
 * @var object $queuedJob
 */

/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob $queuedJob
 */
$current = 'view_job';

?>
<?= $this->element('header', ['data' => compact('current')]) ?>
<div class="row">
    <div class="col">
        <h1>Job <?= h($queuedJob->id) ?></h1>
        <?= $this->element('job', compact('current', 'queuedJob')) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card thick-card">
            <div class="card-body">
                <div class="table-borderless table-hover">
                    <table class="table vertical-table">
                        <tr>
                            <th scope="col"><?= __d('queue', 'Job Type') ?></th>
                            <td><?= h($queuedJob->job_type) ?></td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Job Group') ?></th>
                            <td><?= h($queuedJob->job_group) ?></td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Reference') ?></th>
                            <td><?= h($queuedJob->reference) ?></td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Status') ?></th>
                            <td><?= h($queuedJob->status) ?></td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Progress') ?></th>
                            <td>
                                <?php if (!$queuedJob->failed) { ?>
                                    <?php echo $this->QueueProgress->progress($queuedJob) ?>
                                    <br>
                                    <?php
                                    $textProgressBar = $this->QueueProgress->progressBar($queuedJob, 18);
                                    echo $this->QueueProgress->htmlProgressBar($queuedJob, $textProgressBar);
                                    ?>
                                <?php } else { ?>
                                    <i><?= __d('queue', 'Aborted') ?></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Workerkey') ?></th>
                            <td>
                                <?= h($queuedJob->workerkey) ?>
                                <?php if ($queuedJob->worker_process) { ?>
                                    [<?php echo $this->Html->link($queuedJob->worker_process->server ?: $queuedJob->worker_process->pid, ['controller' => 'QueueProcesses', 'action' => 'view', $queuedJob->worker_process->id]); ?>]
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Priority') ?></th>
                            <td><?= $this->Number->format($queuedJob->priority) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card thick-card">
            <div class="card-body">
                <div class="table-borderless table-hover">
                    <table class="table vertical-table">
                        <tr>
                            <th scope="col"><?= __d('queue', 'Created') ?></th>
                            <td><?= $this->Time->nice($queuedJob->created) ?></td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Notbefore') ?></th>
                            <td>
                                <?= $this->Time->nice($queuedJob->notbefore) ?>
                                <br>
                                <?php echo $this->QueueProgress->timeoutProgressBar($queuedJob, 18); ?>
                                <?php if ($queuedJob->notbefore && $queuedJob->notbefore->isFuture()) {
                                    echo '<div><small>';
                                    echo $this->Time::relLengthOfTime($queuedJob->notbefore);
                                    echo '</small></div>';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Fetched') ?></th>
                            <td>
                                <?= $this->Time->nice($queuedJob->fetched) ?>
                                <?php if ($queuedJob->fetched) {
                                    echo '<div><small>';
                                    echo __d('queue', 'Delay') . ': ' . $this->Time->duration($queuedJob->fetched->diff($queuedJob->created));
                                    echo '</small></div>';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Completed') ?></th>
                            <td>
                                <?= $this->Time->nice($queuedJob->completed) ?>
                                <?php if ($queuedJob->completed) {
                                    echo '<div><small>';
                                    echo __d('queue', 'Duration') . ': ' . $this->Time->duration($queuedJob->completed->diff($queuedJob->fetched));
                                    echo '</small></div>';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><?= __d('queue', 'Failed') ?></th>
                            <td>
                                <?= $queuedJob->failed ? $this->Format->ok($this->Number->format($queuedJob->failed) . 'x', !$queuedJob->failed)  : '' ?>
                                <?php
                                if ($queuedJob->fetched && $queuedJob->failed) {
                                    echo ' ' . $this->Form->postLink(__d('queue', 'Soft reset'), ['controller' => 'Queue', 'action' => 'resetJob', $queuedJob->id], ['confirm' => 'Sure?', 'class' => 'button button-primary btn margin btn-primary']);
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($queuedJob->has('data')) : ?>
<div class="row">
    <div class="col">
        <div class="card thick-card">
            <div class="card-body">
                <h3><?= __d('queue', 'Data') ?></h3>
                <?= $this->Job->jobData($queuedJob->data) ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($queuedJob->hasValue('failure_message')) : ?>
<div class="row">
    <div class="col">
        <h3><?= __d('queue', 'Failure Message') ?></h3>
        <?= $this->Text->autoParagraph(h($queuedJob->failure_message)); ?>
    </div>
</div>
<?php endif; ?>
