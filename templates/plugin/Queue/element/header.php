<?php
/**
 * @var AppView $this
 * @var array|null $data
 */

use App\View\AppView;

if (!isset($data)) {
    $data = [];
}

?>
<div class="row">
    <?= $this->element('toolbar', $data) ?>
    <?= $this->element('time') ?>
</div>
<br/>
