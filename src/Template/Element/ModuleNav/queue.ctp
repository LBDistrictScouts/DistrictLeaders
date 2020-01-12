<?php
/**
 * @var \App\View\AppView $this
 * @var integer $loggedInUserId
 */
?>
<nav class="navbar navbar-light navbar-expand-md text-white-50 bg-dark navigation-clean-search sticky-top">
    <div class="container"><?= $this->Html->link(__d('queue', 'Queue'), ['controller' => 'Queue', 'action' => 'index'], ['class' => 'navbar-brand text-white-50']) ?>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
             id="navcol-1">
            <ul class="nav navbar-nav">
                <li class="nav-item" role="presentation"><?php echo $this->Html->link(__d('queue', 'List {0}', __d('queue', 'Queued Jobs')), ['controller' => 'QueuedJobs', 'action' => 'index'], ['class' => 'nav-link text-white-50']); ?></li>
                <li class="nav-item" role="presentation"><?php echo $this->Form->postLink(__d('queue', 'Reset {0}', __d('queue', 'Failed Jobs')), ['action' => 'reset'], ['confirm' => __d('queue', 'Sure? This will make all failed jobs ready for re-run.'), 'class' => 'nav-link text-white-50']); ?></li>
                <li class="nav-item" role="presentation"><?php echo $this->Form->postLink(__d('queue', 'Reset {0}', __d('queue', 'All Jobs')), ['action' => 'reset', '?' => ['full' => true]], ['confirm' => __d('queue', 'Sure? This will make all failed as well as still running jobs ready for re-run.'), 'class' => 'nav-link text-white-50']); ?></li>
                <li class="nav-item" role="presentation"><?php echo $this->Form->postLink(__d('queue', 'Hard Reset {0}', __d('queue', 'Queue')), ['action' => 'hardReset'], ['confirm' => __d('queue', 'Sure? This will delete all jobs and completely reset the queue.'), 'class' => 'nav-link text-white-50']); ?></li>

            </ul>
            <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index'], 'class' => 'form-inline ml-auto', 'valueSources' => 'query']) ?>
                <div class="form-group text-white-50">
                    <?= $this->Form->label('q', '<i class="fal fa-search"></i>', ['escape' => false]) ?>
                    <?= $this->Form->control('q', ['class' => 'form-control flex-fill search-field', 'type' => 'search', 'placeholder' => 'Search Queued Jobs...']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</nav>

