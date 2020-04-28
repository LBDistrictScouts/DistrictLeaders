<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 *
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $filterArray
 * @var array $appliedFilters
 */

$entity = $this->fetch('entity');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <?php
                        $subset = $this->fetch('subset', 'All');
                        if (!empty($appliedFilters)) {
                            $subset = $this->Text->toList($appliedFilters);
                        } ?>
                        <h3><?= h($subset) ?> <?= $this->Inflection->space($entity) ?></h3>
                    </div>
                    <?php if ($this->fetch('add')) : ?>
                        <div class="col-12 col-md-6 text-md-right">
                            <?= $this->Html->link('Add New ' . $this->Inflection->singleSpace($entity), ['controller' => $this->fetch('entity'), 'action' => 'add'], ['class' => 'btn btn-outline-primary'])  ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (isset($filterArray)) : ?>
                <div class="row">
                    <div class="col">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <?php
                                /** @var string $filterItem */
                                foreach ($filterArray as $id => $filterItem) :
                                    $urlQuery = $this->getRequest()->getQueryParams();
                                    if (key_exists($filterItem, $urlQuery)) {
                                        $active = $urlQuery[$filterItem];
                                    } else {
                                        $active = false;
                                    }
                                    $onlyActive = in_array($filterItem, $appliedFilters) && count($appliedFilters) == 1;
                                    $outputQuery = $urlQuery;
                                    $outputQuery[$filterItem] = !$active;
                                    ?>
                                    <a href="<?= $this->Html->Url->build(['?' => $outputQuery]) ?>" class="btn btn-<?= $active ? 'success' : 'secondary' ?>">
                                        <?= h($filterItem) ?> <span class="badge"><?= $onlyActive ? 'ONLY' : '' ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
                        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (key_exists('related', $this->blocks())) : ?>
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
