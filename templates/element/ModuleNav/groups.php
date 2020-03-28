<?php
/**
 * @var \App\View\AppView $this
 * @var integer $loggedInUserId
 */
?>
<nav class="navbar navbar-light navbar-expand-md text-white-50 bg-dark navigation-clean-search sticky-top">
    <div class="container"><?= $this->Html->link('Groups', ['controller' => 'ScoutGroups', 'action' => 'index'], ['class' => 'navbar-brand text-white-50'])  ?>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
             id="navcol-1">
            <ul class="nav navbar-nav">
                <li class="nav-item" role="presentation"><?= $this->Html->link('List Sections', ['controller' => 'Sections', 'action' => 'index'], ['class' => 'nav-link text-white-50'])  ?></li>
                <li class="nav-item" role="presentation"><?= $this->Html->link('Add Scout Group', ['controller' => 'ScoutGroups', 'action' => 'add'], ['class' => 'nav-link text-white-50'])  ?></li>
                <li class="nav-item" role="presentation"><?= $this->Html->link('Add Section', ['controller' => 'Sections', 'action' => 'add'], ['class' => 'nav-link text-white-50'])  ?></li>
            </ul>
            <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'search'], 'class' => 'form-inline ml-auto', 'valueSources' => 'query']) ?>
                <div class="form-group text-white-50">
                    <?= $this->Form->label('q', '<i class="fal fa-search"></i>', ['escape' => false]) ?>
                    <?= $this->Form->control('q', ['class' => 'form-control flex-fill search-field', 'type' => 'search', 'label' => false, 'placeholder' => 'Search Groups...']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</nav>

