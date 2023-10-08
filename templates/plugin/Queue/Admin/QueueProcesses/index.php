<?php
/**
 * @var AppView $this
 * @var QueueProcess[]|CollectionInterface $queueProcesses
 */

use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Queue\Model\Entity\QueueProcess;
use Queue\Queue\Config;
?>
<?= $this->element('header', ['current' => 'process-list']) ?>
<div>
    <h1><?= __d('queue', 'Queue Processes') ?></h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('pid') ?></th>
                <th><?= $this->Paginator->sort('created', __d('queue', 'Started'), ['direction' => 'desc']) ?></th>
                <th><?= $this->Paginator->sort('modified', __d('queue', 'Last Run'), ['direction' => 'desc']) ?></th>
                <th><?= $this->Paginator->sort('terminate', __d('queue', 'Active')) ?></th>
                <th><?= $this->Paginator->sort('server') ?></th>
                <th class="actions"><?= __d('queue', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($queueProcesses as $queueProcess) : ?>
            <tr>
                <td>
                    <?= h($queueProcess->pid) ?>
                    <?php if ($queueProcess->workerkey && $queueProcess->workerkey !== $queueProcess->pid) { ?>
                        <div><small><?php echo h($queueProcess->workerkey); ?></small></div>
                    <?php } ?>
                </td>
                <td>
                    <?= $this->Time->nice($queueProcess->created) ?>
                    <?php if (!$queueProcess->created->addSeconds(Config::workermaxruntime())->isFuture()) {
                        echo $this->Format->icon('warning', ['title' => 'Long running (!)']);
                    } ?>
                </td>
                <td>
                    <?php
                        $modified = $this->Time->nice($queueProcess->modified);
                    if (!$queueProcess->created->addSeconds(Config::defaultworkertimeout())->isFuture()) {
                        $modified = '<span class="disabled" title="Beyond default worker timeout!">' . $modified . '</span>';
                    }
                        echo $modified;
                    ?>
                </td>
                <td><?= $this->Format->yesNo(!$queueProcess->terminate) ?></td>
                <td><?= h($queueProcess->server) ?></td>
                <td class="actions">
                    <?= $this->Html->link($this->Icon->iconHtml('fa-eye'), ['action' => 'view', $queueProcess->id], ['escapeTitle' => false]); ?>
                <?php if (!$queueProcess->terminate) { ?>
                    <?= $this->Form->postLink($this->Icon->iconHtml('fa-skull-crossbones'), ['action' => 'terminate', $queueProcess->id], ['escapeTitle' => false, 'confirm' => __d('queue', 'Are you sure you want to terminate Process ID #{0}?', $queueProcess->pid)]); ?>
                <?php } ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $this->element('Tools.pagination'); ?>
</div>
