<?php
/**
 * @var AppView $this
 * @var array $processes
 * @var QueueProcess[] $terminated
 * @var QueuedJob $queuedJob
 */

use App\View\AppView;
use Cake\I18n\Time;
use Queue\Model\Entity\QueuedJob;
use Queue\Model\Entity\QueueProcess;

?>
<?= $this->element('header', ['current' => 'processes']) ?>
<div>
    <h1><?php echo __d('queue', 'Current Queue Processes'); ?></h1>
    <?= $this->element('control') ?>
    <p><?php echo __d('queue', 'Active processes'); ?>:</p>

<ul>
<?php
foreach ($processes as $process => $timestamp) {
    echo '<li>' . $process . ':';
    echo '<ul>';
    echo '<li>Last run: ' . $this->Time->nice(new Time($timestamp)) . '</li>';

    echo '<li>End: ' . $this->Form->postLink(__d('queue', 'Finish current job and end'), ['action' => 'processes', '?' => ['end' => $process]], ['confirm' => 'Sure?', 'class' => 'button secondary btn margin btn-secondary']) . ' (next loop run)</li>';
    if (!$this->Configure->read('Queue.multiserver')) {
        echo '<li>' . __d('queue', 'Kill') . ': ' . $this->Form->postLink(__d('queue', 'Soft kill'), ['action' => 'processes', '?' => ['kill' => $process]], ['confirm' => 'Sure?']) . ' (termination SIGTERM = 15)</li>';
    }

    echo '</ul>';
    echo '</li>';
}
if (empty($processes)) {
    echo 'n/a';
}
?>
</ul>

<?php if (!empty($terminated)) { ?>
    <h3><?php echo __d('queue', 'Terminated') ?></h3>
    <p><?php echo __d('queue', 'These have been marked as to be terminated after finishing this round'); ?>:</p>
    <ul>
    <?php
    foreach ($terminated as $queuedJob) {
        echo '<li>' . $queuedJob->pid;
        echo '</li>';
    }
    ?>
    </ul>
<?php } ?>

</div>
