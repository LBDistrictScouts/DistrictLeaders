<?php
/**
 * @var AppView $this
 * @var QueuedJob[] $pendingDetails
 * @var string[] $tasks
 * @var string[] $servers
 * @var array $status
 * @var int $new
 * @var int $current
 * @var array $data
 */

use App\View\AppView;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Queue\Model\Entity\QueuedJob;

?>
<?= $this->element('header', ['data' => ['current' => 'dashboard']]) ?>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12">
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
                    /** @var FrozenTime $time */
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
        <?= $this->element('control') ?>
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
                <?php foreach ($pendingDetails as $pendingJob) : ?>
                    <div class="card">
                        <div class="card-header">
                            <?= $this->Html->link($this->Inflection->space($pendingJob->job_type), ['controller' => 'QueuedJobs', 'action' => 'view', $pendingJob->id]) ?> (<?= $pendingJob->reference ? 'Reference <code>' . h($pendingJob->reference) . '</code>, ' : '' ?>Priority <?= $pendingJob->priority ?>)
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
                                        <?= __d('queue', 'Created') ?>: <?= $this->Time->format($pendingJob->created, 'dd-MMM-yy HH:mm') ?>
                                    </li>
                                    <?php $notBefore = ''; if ($pendingJob->notbefore) : ?>
                                        <li><?= __d('queue', 'Scheduled: {0}', $this->Time->format($pendingJob->notbefore, 'dd-MMM-yy HH:mm')) ?></li>
                                    <?php endif; ?>

                                    <?php

                                    if ($pendingJob->fetched) {
                                        echo '<li>' . __d('queue', 'Fetched') . ': ' . $this->Time->format($pendingJob->fetched, 'dd-MMM-yy HH:mm') . '</li>';

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
                    <br />
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
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
                                        'maxworkers' => 'maxWorkerCount',
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
                                    } elseif (is_integer($configuration) && $key != 'maxWorkerCount') {
                                        $configuration = gmdate('i:s', $configuration);
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

