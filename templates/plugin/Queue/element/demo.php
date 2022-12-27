<?php
/**
 * @var AppView $this
 * @var mixed $tasks
 */

use App\View\AppView;
use Cake\Core\Configure;

?>
<?php if (Configure::read('debug')) : ?>
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
<?php endif; ?>
