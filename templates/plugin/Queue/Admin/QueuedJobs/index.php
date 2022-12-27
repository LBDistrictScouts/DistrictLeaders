<?php
/**
 * @var AppView $this
 * @var QueuedJob[]|CollectionInterface $queuedJobs
 */

use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Queue\Model\Entity\QueuedJob;

?>
<?= $this->element('header', ['data' => ['current' => 'index']]) ?>
<div class="row">
    <div class="col">
        <h1><?= __d('queue', 'Queued Jobs') ?></h1>
        <?php
        if (Configure::read('Queue.isSearchEnabled') !== false && Plugin::isLoaded('Search')) {
            echo $this->element('Queue.search');
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('job_type') ?></th>
                    <th><?= $this->Paginator->sort('created', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('notbefore', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('fetched', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('completed', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('failed') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __d('queue', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($queuedJobs as $queuedJob) : ?>
                    <tr>
                        <td><?= $this->Number->format($queuedJob->id) ?></td>
                        <td><?= h($queuedJob->job_type) ?></td>
                        <td><?= $this->Time->format($queuedJob->created, 'dd-MMM-yy HH:ss') ?></td>
                        <td>
                            <?= $this->Time->format($queuedJob->notbefore, 'dd-MMM-yy HH:ss') ?>
                            <br>
                            <?php echo $this->QueueProgress->timeoutProgressBar($queuedJob, 8); ?>
                            <?php if ($queuedJob->notbefore && $queuedJob->notbefore->isFuture()) {
                                echo '<div><small>';
                                echo $this->Time->relLengthOfTime($queuedJob->notbefore);
                                echo '</small></div>';
                            } ?>
                        </td>
                        <td>
                            <?= $this->Time->format($queuedJob->fetched, 'dd-MMM-yy HH:ss') ?>

                            <?php if ($queuedJob->fetched) {
                                echo '<div><small>';
                                echo $this->Time->relLengthOfTime($queuedJob->fetched);
                                echo '</small></div>';
                            } ?>
                        </td>
                        <td>
                            <?= $this->Time->format($queuedJob->completed, 'dd-MMM-yy HH:ss') ?>

                            <?php if ($queuedJob->completed) {
                                echo '<div><small>';
                                echo $this->Time->relLengthOfTime($queuedJob->completed);
                                echo '</small></div>';
                            } ?>
                        </td>
                        <td><?= $this->Format->ok($this->Number->format($queuedJob->failed) . 'x', !$queuedJob->failed); ?></td>
                        <td>
                            <?= h($queuedJob->status) ?>
                            <?php if ($queuedJob->fetched) { ?>
                                <div>
                                    <?php if (!$queuedJob->failed) : ?>
                                        <?php echo $this->QueueProgress->progress($queuedJob) ?>
                                        <br>
                                        <?php
                                        $textProgressBar = $this->QueueProgress->progressBar($queuedJob, 8);
                                        echo $this->QueueProgress->htmlProgressBar($queuedJob, $textProgressBar);
                                        ?>
                                    <?php else : ?>
                                        <i><?= __d('queue', 'Aborted') ?></i>
                                    <?php endif; ?>
                                </div>
                            <?php } ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link($this->Icon->iconHtml('fa-eye'), ['action' => 'view', $queuedJob->id], ['escapeTitle' => false]); ?>
                            <?php if (!$queuedJob->completed) { ?>
                                <?= $this->Html->link($this->Icon->iconHtml('fa-pencil'), ['action' => 'edit', $queuedJob->id], ['escapeTitle' => false]); ?>
                            <?php } ?>
                            <?= $this->Form->postLink($this->Icon->iconHtml('fa-trash-alt'), ['action' => 'delete', $queuedJob->id], ['escapeTitle' => false, 'confirm' => __d('queue', 'Are you sure you want to delete # {0}?', $queuedJob->id)]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('Tools.pagination'); ?>
    </div>
</div>
