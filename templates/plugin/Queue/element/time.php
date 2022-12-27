<?php
/**
 * @var AppView $this
 */

use App\View\AppView;
use Cake\I18n\FrozenTime;
?>
<div class="col col-md-3 d-flex justify-content-end">
    <?= __d('queue', 'Server Time') ?>:
    <?= $this->Time->format(new FrozenTime(), 'dd-MMM-yy HH:mm') ?>
</div>
