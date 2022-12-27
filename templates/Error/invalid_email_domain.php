<?php
/**
 * @var AppView $this
 * @var object $error
 * @var mixed $message
 */

use App\View\AppView;

$this->setLayout('error');
?>
<h2><?= h($message) ?></h2>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
