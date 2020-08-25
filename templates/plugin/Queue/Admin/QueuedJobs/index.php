<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[]|\Cake\Collection\CollectionInterface $queuedJobs
 */

use Cake\Core\Configure;
use Cake\Core\Plugin;

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
                    <th><?= $this->Paginator->sort('job_type') ?></th>
                    <th><?= $this->Paginator->sort('job_group') ?></th>
                    <th><?= $this->Paginator->sort('reference') ?></th>
                    <th><?= $this->Paginator->sort('created', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('notbefore', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('fetched', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('completed', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('failed') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('priority', null, ['direction' => 'desc']) ?></th>
                    <th class="actions"><?= __d('queue', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($queuedJobs as $queuedJob) : ?>
                    <tr>
                        <td><?= h($queuedJob->job_type) ?></td>
                        <td><?= h($queuedJob->job_group) ?></td>
                        <td>
                            <?= h($queuedJob->reference) ?>
                            <?php if ($queuedJob->data) {
                                echo $this->Format->icon('cubes', ['title' => $this->Text->truncate($queuedJob->data, 1000)]);
                            }
                            ?>
                        </td>
                        <td><?= $this->Time->nice($queuedJob->created) ?></td>
                        <td>
                            <?= $this->Time->nice($queuedJob->notbefore) ?>
                            <br>
                            <?php echo $this->QueueProgress->timeoutProgressBar($queuedJob, 8); ?>
                            <?php if ($queuedJob->notbefore && $queuedJob->notbefore->isFuture()) {
                                echo '<div><small>';
                                echo $this->Time->relLengthOfTime($queuedJob->notbefore);
                                echo '</small></div>';
                            } ?>
                        </td>
                        <td>
                            <?= $this->Time->nice($queuedJob->fetched) ?>

                            <?php if ($queuedJob->fetched) {
                                echo '<div><small>';
                                echo $this->Time->relLengthOfTime($queuedJob->fetched);
                                echo '</small></div>';
                            } ?>

                            <?php if ($queuedJob->workerkey) { ?>
                                <div><small><code><?php echo h($queuedJob->workerkey); ?></code></small></div>
                            <?php } ?>
                        </td>
                        <td><?= $this->Time->nice($queuedJob->completed) ?></td>
                        <td><?= $this->Format->ok($this->Number->format($queuedJob->failed) . 'x', !$queuedJob->failed); ?></td>
                        <td>
                            <?= h($queuedJob->status) ?>
                            <?php if ($queuedJob->fetched) { ?>
                                <div>
                                    <?php if (!$queuedJob->failed) { ?>
                                        <?php echo $this->QueueProgress->progress($queuedJob) ?>
                                        <br>
                                        <?php
                                        $textProgressBar = $this->QueueProgress->progressBar($queuedJob, 8);
                                        echo $this->QueueProgress->htmlProgressBar($queuedJob, $textProgressBar);
                                        ?>
                                    <?php } else { ?>
                                        <i><?= __d('queue', 'Aborted') ?></i>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?= $this->Number->format($queuedJob->priority) ?></td>
                        <td class="actions">
                            <?= $this->Html->link($this->Format->icon('view'), ['action' => 'view', $queuedJob->id], ['escapeTitle' => false]); ?>

                            <?php if (!$queuedJob->completed) { ?>
                                <?= $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $queuedJob->id], ['escapeTitle' => false]); ?>
                            <?php } ?>
                            <?= $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $queuedJob->id], ['escapeTitle' => false, 'confirm' => __d('queue', 'Are you sure you want to delete # {0}?', $queuedJob->id)]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('Tools.pagination'); ?>
    </div>
</div>
