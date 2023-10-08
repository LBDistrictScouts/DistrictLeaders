<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 *
 * @var AppView $this
 * @var ResultSet $filterArray
 * @var array $appliedFilters
 */

use App\View\AppView;
use Cake\ORM\ResultSet;

$entity = $this->fetch('entity');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"></div>
            <?= $this->element('search') ?>
            <div class="card-header"></div>
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
