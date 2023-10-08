<?php
/**
 * @var AppView $this
 * @var mixed $_isSearch
 */

use App\View\AppView;

?>
<br />
<div class="card">
    <div class="card-body">
        <?= $this->Form->create(null, ['valueSources' => 'query']) ?>
        <div class="form-row">
            <div class="col">
                <?= $this->Form->control('search', ['placeholder' => 'Auto-wildcard mode', 'label' => 'Search (Jobgroup/Reference)']) ?>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <?= $this->Form->control('job_type', ['empty' => ' - no filter - ']) ?>
            </div>
            <div class="col">
                <?= $this->Form->control('status', ['options' => ['completed' => 'Completed', 'in_progress' => 'In Progress'], 'empty' => ' - no filter - ']) ?>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="col">
                <?= $this->Form->button('Filter', ['type' => 'submit', 'class' => 'btn-block']) ?>
            </div>
            <div class="col">

                <?= $this->Html->link('Reset', ['action' => 'index'], ['class' => 'btn btn-warning btn-block', 'role' => 'button']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>


