<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 */
?>
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h3><i class="fal <?= $this->fetch('icon') ?> fa-fw"></i> Add <?= $this->Inflection->singleSpace($this->fetch('entity')) ?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
			            <?= $this->fetch('content') ?>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                <?= $this->Form->button('Create ' . $this->Inflection->singleSpace($this->fetch('entity')), ['class' => 'btn btn-outline-success btn-lg']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>