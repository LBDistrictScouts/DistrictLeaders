<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $pendingDetails
 * @var string[] $tasks
 * @var string[] $servers
 * @var array $status
 * @var int $new
 * @var int $current
 * @var array $data
 */
use Cake\Core\Configure;

?>
<?= $this->element('header', ['data' => ['current' => 'dashboard']]) ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2><?php echo __d('queue', 'Status'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if ($status) { ?>
                    <?php
                    /** @var \Cake\I18n\FrozenTime $time */
                    $time = $status['time'];
                    $running = $time->addMinute()->isFuture();
                    ?>
                    <?php echo $this->Format->yesNo($running); ?> <?php echo $running ? __d('queue', 'Running') : __d('queue', 'Not running'); ?> (<?php echo __d('queue', 'last {0}', $this->Time->relLengthOfTime($status['time']))?>)

                    <?php
                    echo '<div><small>Currently ' . $this->Html->link($status['workers'] . ' worker(s)', ['action' => 'processes']) . ' total.</small></div>';
                    ?>
                    <?php
                    echo '<div><small>' . count($servers) . ' CLI server(s): ' . implode(', ', $servers) . '</small></div>';
                    ?>

                <?php } else { ?>
                    n/a
                <?php } ?>
            </div>
        </div>
        <br/>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2><?php echo __d('queue', 'Queued Jobs'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p><?= __d('queue', '{0} task(s) newly await processing.', $new . '/' . $current) ?></p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <?php foreach ($pendingDetails as $pendingJob) : ?>
                            <tr>
                                <td>
                                    <div class="card">
                                        <div class="card-header">
                                            <?= $this->Html->link($this->Inflection->space($pendingJob->job_type), ['controller' => 'QueuedJobs', 'action' => 'view', $pendingJob->id]) ?> (Reference <code><?= h($pendingJob->reference ?: '-') ?></code>, Priority <?= $pendingJob->priority ?>)
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <?php
                                                    $reset = '';
                                                if ($pendingJob->failed) {
                                                    $reset = ' ' . $this->Form->postLink(__d('queue', 'Soft reset'), ['action' => 'resetJob', $pendingJob->id], ['confirm' => 'Sure?', 'class' => 'button primary btn margin btn-primary']);
                                                    $reset .= ' ' . $this->Form->postLink(__d('queue', 'Remove'), ['action' => 'removeJob', $pendingJob->id], ['confirm' => 'Sure?', 'class' => 'button secondary btn margin btn-default']);
                                                } elseif ($pendingJob->fetched) {
                                                    $reset .= ' ' . $this->Form->postLink(__d('queue', 'Remove'), ['action' => 'removeJob', $pendingJob->id], ['confirm' => 'Sure?', 'class' => 'button secondary btn margin btn-default']);
                                                } ?>

                                                    <li>
                                                        <?= __d('queue', 'Created') ?>: <?= $this->Time->nice($pendingJob->created) ?>
                                                    </li>
                                                    <?php $notBefore = ''; if ($pendingJob->notbefore) : ?>
                                                        <li><?= __d('queue', 'Scheduled: {0}', $this->Time->nice($pendingJob->notbefore)) ?></li>
                                                    <?php endif; ?>

                                                    <?php

                                                    if ($pendingJob->fetched) {
                                                        echo '<li>' . __d('queue', 'Fetched') . ': ' . $this->Time->nice($pendingJob->fetched) . '</li>';

                                                        $status = '';
                                                        if ($pendingJob->status) {
                                                            $status = ' (' . __d('queue', 'status') . ': ' . h($pendingJob->status) . ')';
                                                        }

                                                        if (!$pendingJob->failed) {
                                                            echo '<li>';
                                                            echo __d('queue', 'Progress') . ': ';
                                                            echo $this->QueueProgress->progress($pendingJob) . $status;
                                                            $textProgressBar = $this->QueueProgress->progressBar($pendingJob, 18);
                                                            echo '<br>' . $this->QueueProgress->htmlProgressBar($pendingJob, $textProgressBar);
                                                            echo '</li>';
                                                        } else {
                                                            echo '<li>' . __d('queue', 'Failures') . ': ' . $pendingJob->failed . $reset . '</li>';
                                                            if ($pendingJob->failure_message) {
                                                                echo '<li>' . __d('queue', 'Failure Message') . ': ' . $this->Text->truncate($pendingJob->failure_message, 200) . '</li>';
                                                            }
                                                        }
                                                    } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <br/>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2><?php echo __d('queue', 'Settings'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                Server:
                <ul>
                    <li>
                        <code>posix</code> extension enabled (optional, recommended): <?php echo $this->Format->yesNo(function_exists('posix_kill')); ?>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th scope="col">Config Key</th>
                            <th scope="col">Config Value</th>
                        </tr>
                        <?php
                        $configurations = Configure::read('Queue');
                        foreach ($configurations as $key => $configuration) : ?>
                            <tr>
                                <?php
                                    $replacements = [
                                        'defaultworkertimeout' => 'defaultWorkerTimeout',
                                        'workermaxruntime' => 'workerMaxRuntime',
                                        'cleanuptimeout' => 'cleanupTimeout',
                                        'workertimeout' => 'workerTimeout',
                                        //'isSearchEnabled' => 'isSearchEnabled',
                                        //'isStatisticEnabled' => 'isStatisticEnabled',
                                    ];
                                    if (key_exists($key, $replacements)) {
                                        $key = $replacements[$key];
                                    }

                                    if (is_dir($configuration)) {
                                        $configuration = str_replace(ROOT . DS, 'ROOT' . DS, $configuration);
                                        $configuration = str_replace(DS, '/', $configuration);
                                    } elseif (is_bool($configuration)) {
                                        $configuration = $this->Icon->iconBoolean($configuration);
                                    } elseif (is_integer($configuration)) {
                                        $configuration = gmdate('H:i:s', $configuration);
                                    }
                                    ?>
                                <td><?= $this->Inflection->space($key) ?></td>
                                <td><?= $configuration ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <br/>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2><?php echo __d('queue', 'Statistics'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php foreach ($data as $row) : ?>
                    <h4><?= h($row['job_type']) ?></h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-compact">
                            <tr>
                                <th scope="col">Statistic</th>
                                <th scope="col">Value</th>
                            </tr>
                            <tr>
                                <td>Finished Jobs in Database</td>
                                <td><?= $row['num'] ?></td>
                            </tr>
                            <tr>
                                <td>Average Job Existence</td>
                                <td><?= gmdate('z H:i:s', $row['alltime']) ?></td>
                            </tr>
                            <tr>
                                <td>Average Execution Delay</td>
                                <td><?= gmdate('z H:i:s', $row['fetchdelay']) ?></td>
                            </tr>
                            <tr>
                                <td>Average Execution Time</td>
                                <td><?= gmdate('z H:i:s', $row['runtime']) ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($data)) : ?>
                    <p>No Data</p>
                <?php endif; ?>
            </div>
            <?php if (Configure::read('Queue.isStatisticEnabled')) : ?>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col">
                            <p><?php echo $this->Html->link(__d('queue', 'Detailed Statistics'), ['controller' => 'QueuedJobs', 'action' => 'stats']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Trigger Test / Demo Jobs</h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul>
                    <?php
                    foreach ($tasks as $task) :
                        if (substr($task, 0, 11) !== 'Queue.Queue') {
                            continue;
                        }
                        if (substr($task, -7) !== 'Example') {
                            continue;
                        }

                        $task = str_replace('Queue', '', $task);
                        $task = str_replace('.', '', $task);
                        ?>
                        <li>
                            <?= $this->Form->postLink($this->Inflection->space($task), ['action' => 'addJob', substr($task, 11)], ['confirm' => 'Sure?'])  ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer text-muted">
                <?= $this->Html->link(__d('queue', 'Trigger Delayed Test / Demo Job'), ['controller' => 'QueuedJobs', 'action' => 'test'], ['class' => 'btn btn-outline-primary'])  ?>
                <?php if (Configure::read('debug')) : ?>
                    <?= $this->Html->link(__d('queue', 'Trigger Execute Job(s)'), ['controller' => 'QueuedJobs', 'action' => 'execute'], ['class' => 'btn btn-outline-primary'])  ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
