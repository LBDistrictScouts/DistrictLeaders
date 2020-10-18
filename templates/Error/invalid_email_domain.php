<?php
/**
 * @var \App\View\AppView $this
 * @var object $error
 * @var mixed $message
 */

$this->setLayout('error');
?>
<h2><?= h($message) ?></h2>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
