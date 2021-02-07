<?php
/**
 * @var \App\View\AppView $this
 * @var array|null $data
 */

if (!isset($data)) {
    $data = [];
}

?>
<div class="row">
    <?= $this->element('toolbar', $data) ?>
    <?= $this->element('time') ?>
</div>
<br/>
