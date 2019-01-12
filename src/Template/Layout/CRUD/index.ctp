<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 */
?>
<div class="row">
    <div class="col-lg-12">
        <h1><i class="fal <?= $this->fetch('icon') ?> fa-fw"></i> <?= $this->Inflection->space($this->fetch('entity')) ?></h1>
        <br/>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3><?= $this->fetch('subset', 'All') ?> <?= $this->Inflection->space($this->fetch('entity')) ?></h3>
                    </div>
                    <div class="col-12 col-md-6 text-md-right">
                        <?= $this->Html->link('Add New '. $this->Inflection->singleSpace($this->fetch('entity')) , ['controller' => $this->fetch('entity'), 'action' => 'add'], ['class' => 'btn btn-outline-primary'])  ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
			            <?= $this->fetch('content') ?>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->first() ?>
                                <?= $this->Paginator->prev() ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next() ?>
                                <?= $this->Paginator->last() ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (key_exists('related', $this->blocks())): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h3>Related actions</h3>
                </div>
                <div class="card-body">
                    <?= $this->fetch('sidebar') ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>