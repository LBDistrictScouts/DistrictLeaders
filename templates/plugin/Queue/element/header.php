<?php
/**
 * @var \App\View\AppView $this
 * @var array $data
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
